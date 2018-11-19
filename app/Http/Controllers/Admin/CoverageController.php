<?php

namespace App\Http\Controllers\Admin;

use App\AreaOutlineHeader;
use App\AreaOutlineVertex;
use App\City;
use App\Coverage;
use App\CoveragePassThroughType;
use App\Kecamatan;
use App\Kelurahan;
use App\Province;
use App\Region;
use App\Rules\ValidAxisValue;
use App\Rules\ValidPassThroughType;
use App\Street;
use App\SubRegion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CoverageController extends Controller
{
    public function coverage_index(){
        $areas = Coverage::get();

        $data = [
            'areas' => $areas
        ];

        return view('admin/coverage/coverage_index',$data);
    }

    public function read_csv($filename, $length, $delimiter){
        $handle = fopen($filename,'r');
        $hashes = [];
        $values = [];
        $header = null;
//        $headerUnique = null;

        if(!$handle){
            return $values;
        }
        $header = fgetcsv($handle,$length,$delimiter);
        if(!$header){
          return $values;
        }

        while(($data = fgetcsv($handle,$length,$delimiter))!==false){
            $hash = md5(serialize($data));

            if(!isset($hashes[$hash])){
                $hashes[$hash] = true;
                $values[] = array_combine($header,$data);
            }
        }
        fclose($handle);
        return $values;
    }

    public function import_area_information(Request $request){
        $this->validate($request, [
            'area-csv' => 'required|mimes:csv,txt'
        ]);

//        $file =  $request->file('area-csv');
//
//        $filename = "iacsv-".time().".csv";
//        Storage::put('public/area-csv/'.$filename, file_get_contents($file));
//
//        $filepath = asset(Storage::url('public/area-csv/'.$filename));
//        $data = $this->read_csv($filepath,200,",");
//
//        Storage::delete('public/area-csv/'.$filename);
//        echo $data;
//
//        return redirect('/admin/coverage');

        $filepath = $request->file('area-csv')->getRealPath();
        $csvdata = array_map('str_getcsv',file($filepath));

//        return $csvdata;

        $city = "";
        $kelurahan = "";
        $header_id = 0;
        $i = 0;
        $vertex_no = 1;
        foreach ($csvdata as $data){
            if($i!=0) {
                if ($city != $data[3] || $kelurahan != $data[4]) {
                    $header = new AreaOutlineHeader();
                    $header->city = $data[3];
                    $header->kelurahan = $data[4];
                    $city = $data[3];
                    $kelurahan = $data[4];
                    $header->save();
                    $header_id = $header->id;
                    $vertex_no = 1;
                }
                $vertex = new AreaOutlineVertex();
                $vertex->area_outline_header_id = $header_id;
                $vertex->longitude = $data[5];
                $vertex->latitude = $data[6];
                $vertex->vertex_no = $vertex_no;
                $vertex->save();

                $vertex_no++;
            }
            $i++;
        }

        return redirect('admin/coverage')->with('success','Area Outline successfully uploaded.');
    }

    public function import_fiberstar_coverage(Request $request){
        $this->validate($request, [
            'coverage-csv' => 'required|mimes:csv,txt'
        ]);

        $filepath = $request->file('coverage-csv')->getRealPath();
        $csvdata = array_map('str_getcsv',file($filepath));

//        $file =  $request->file('coverage-csv');
//        $filename = "ccsv-".time().".csv";
//        Storage::put('public/coverage-csv/'.$filename, file_get_contents($file));
//        $filepath = asset('storage/coverage-csv/'.$filename);
//        return redirect('/admin/coverage');

        City::truncate();
        Kecamatan::truncate();
        Kelurahan::truncate();
        Street::truncate();

        $i = 0;
        foreach ($csvdata as $data){
            if($i != 0){
                $city_matches = City::where('name',$data[0])->first();
                if($city_matches == null){
                    $city = new City();
                    $city->name = $data[0];
//                    $city->province_id = $province_matches->id;
                    $city->save();
                    $city_matches = $city;
                }

                $kecamatan_matches = Kecamatan::where('name',$data[1])->first();
                if($kecamatan_matches == null){
                    $kecamatan = new Kecamatan();
                    $kecamatan->name = $data[1];
                    $kecamatan->city_id = $city_matches->id;
                    $kecamatan->save();
                    $kecamatan_matches = $kecamatan;
                }
                else{   //kecamatan name may be same but from different city
                    $city_of_match = City::where('id',$kecamatan_matches->city_id)->first();
                    if($city_of_match->name != $data[0]){
                        $kecamatan = new Kecamatan();
                        $kecamatan->name = $data[1];
                        $kecamatan->city_id = $city_matches->id;
                        $kecamatan->save();
                        $kecamatan_matches = $kecamatan;
                    }
                }

                $kelurahan_matches = Kelurahan::where('name',$data[2])->first();
                if($kelurahan_matches == null){
                    $kelurahan = new Kelurahan();
                    $kelurahan->name = $data[2];
                    $kelurahan->kecamatan_id = $kecamatan_matches->id;
                    $kelurahan->save();
                    $kelurahan_matches = $kelurahan;
                }
                else{
                    $kecamatan_of_match = Kecamatan::where('id',$kelurahan_matches->kecamatan_id)->first();
                    if($kecamatan_of_match->name != $data[1]){
                        $kelurahan = new Kelurahan();
                        $kelurahan->name = $data[2];
                        $kelurahan->kecamatan_id = $kecamatan_matches->id;
                        $kelurahan->save();
                        $kelurahan_matches = $kelurahan;
                    }
                }

                $street_matches = Street::where('name',$data[3])->first();
                if($street_matches == null){
                    $street = new Street();
                    $street->name = $data[3];
                    $street->kelurahan_id = $kelurahan_matches->id;
                    $street->save();
                }
                else{
                    $kelurahan_of_match = Kelurahan::where('id',$street_matches->kelurahan_id)->first();
                    if($kelurahan_of_match->name != $data[2]){
                        $street = new Street();
                        $street->name = $data[3];
                        $street->kelurahan_id = $kelurahan_matches->id;
                        $street->save();
                    }
                }
            }
            $i++;
        }
        return redirect('admin/coverage')->with('success','FiberStar Coverage successfully uploaded.');
    }

    public function add_coverage_form(){

        $types = CoveragePassThroughType::get();

        $data = [
            'title' => 'Add Coverage Point',
            'types' => $types
        ];

        return view('admin/coverage/coverage_form',$data);
    }

    public function add_coverage(Request $request){

        $this->validate($request,[
            'place' => 'required',
            'latitude' => ['required', new ValidAxisValue()],
            'longitude' => ['required', new ValidAxisValue()],
            'pass_through_type' => ['required', new ValidPassThroughType()]
        ]);

        $area = new Coverage();

        $area->place = $request->place;
        $area->latitude = $request->latitude;
        $area->longitude = $request->longitude;
        $area->pass_through_type_id = $request->pass_through_type;
        $area->save();

        return redirect('admin/coverage');
    }

    public function edit_coverage_form($id){
        $types = CoveragePassThroughType::get();
        $area = Coverage::where('id',$id)->first();

        $data = [
            'title' => 'Edit Coverage Point',
            'area' => $area,
            'types' => $types
        ];

        return view('admin/coverage/coverage_form',$data);
    }

    public function edit_coverage(Request $request){
        $this->validate($request,[
            'place' => 'required',
            'latitude' => ['required', new ValidAxisValue()],
            'longitude' => ['required', new ValidAxisValue()],
            'pass_through_type' => ['required', new ValidPassThroughType()]
        ]);

        $area = Coverage::where('id',$request->id)->first();

        $area->place = $request->place;
        $area->latitude = $request->latitude;
        $area->longitude = $request->longitude;
        $area->pass_through_type_id = $request->pass_through_type;
        $area->save();

        return redirect('admin/coverage');

    }

    public function delete_coverage(Request $request){

        $data = Coverage::where('id',$request->id)->first();

        if($data!=null){
            $data = Coverage::where('id',$request->id)->first();
            $data->delete();
        }

        return redirect('admin/coverage');
    }
}

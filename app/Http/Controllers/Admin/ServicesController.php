<?php

namespace App\Http\Controllers\Admin;

use App\Rules\QuillRequired;
use App\Service;
use App\ServiceAdvantage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class ServicesController extends Controller
{
    public function services_index(){
        $services = Service::get();

        foreach ($services as $service){
            $description = strip_tags($service->description);
            if(strlen($description) > 150){
                $description = substr($description,0,150).'...';
            }
            $service->description = $description;
        }

        $data = [
            'services' => $services
        ];

        return view('admin/services/services_index',$data);
    }

    public function add_service_form(){
        $data=[
            'title' => 'Add Service'
        ];

        return view('admin/services/service_form', $data);
    }

    public function add_service(Request $request){
        $this->validate($request, [
            'service_name' => 'required',
            'description' => ['required', new QuillRequired()],
            'image' => 'mimes:jpg,jpeg,bmp,png|required'
        ]);

        $service = new Service();
        $service->service_name = $request->service_name;
        $service->description = $request->description;

        $image = Image::make( $request->file('image'))->encode('png');
        $filename = 'se-'.time().'.png';
        Storage::put('public/services/'.$filename, (string)$image);

        $service->image_link = 'storage/services/'.$filename;
        $service->save();

        if($request->has('advantages')){
            foreach ($request->advantages as $advantage){
                if($advantage!=""){
                    $data = new ServiceAdvantage();
                    $data->service_id = $service->id;
                    $data->advantage = $advantage;
                    $data->save();
                }
            }
        }

        return redirect('admin/services');
    }

    public function edit_service_form($id){

        $service = Service::where('id',$id)->first();

        $data=[
            'title' => 'Edit Service',
            'service' => $service
        ];

        return view('admin/services/service_form', $data);
    }

    public function edit_service(Request $request){

        $this->validate($request, [
            'service_name' => 'required',
            'description' => ['required', new QuillRequired()],
            'image' => 'mimes:jpg,jpeg,bmp,png',
            'readonly-filename' => 'required'
        ]);

        $service = Service::where('id',$request->id)->first();
        $service->service_name = $request->service_name;
        $service->description = $request->description;

        $ids = json_decode($request->to_be_deleted);
        if($ids != null){
            foreach ($ids as $id){
                if($id!=0) {
                    ServiceAdvantage::where('id', $id)->delete();
                }
            }
        }

        if($request->has('advantage_ids')) {
            $index = 0;
            foreach ($request->advantage_ids as $id) {
                if ($id == 0) {
                    if ($request->advantages[$index] != "") {
                        $advantage = new ServiceAdvantage();
                        $advantage->service_id = $service->id;
                        $advantage->advantage = $request->advantages[$index];
                        $advantage->save();
                    }
                } else {
                    if ($request->advantages[$index] != "") {
                        $advantage = ServiceAdvantage::where('id', $id)->first();
                        $advantage->advantage = $request->advantages[$index];
                        $advantage->save();
                    } else {
                        $advantage = ServiceAdvantage::where('id', $id)->first();
                        $advantage->delete();
                    }
                }
                $index++;
            }
        }

        if($request->hasFile('image')){
            Storage::delete('public/services/'.$service->image_link);

            $image = Image::make( $request->file('image'))->encode('png');
            $filename = 'ni-'.time().'.png';
            Storage::put('public/services/'.$filename, (string)$image);

            $service->image_link = 'storage/services/'.$filename;
        }
        $service->save();

        return redirect('admin/services');
    }

    public function delete_service(Request $request){
        $service = Service::where('id',$request->id)->first();

        if($service!=null){
            ServiceAdvantage::where('service_id',$service->id)->delete();
            Storage::delete('public/services/'.$service->image_link);
            $service->delete();
        }

        return redirect('admin/services');
    }
}

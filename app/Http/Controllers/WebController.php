<?php

namespace App\Http\Controllers;

use App\AreaOutlineHeader;
use App\City;
use App\JobVacancy;
use App\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class WebController extends Controller
{
    public function HomePage(){
        return view('pageHome');
    }

    public function NewsPage(){
        return view('pageNews');
    }

    public function AboutUsPage(){
        return view('pageAbout');
    }

    public function OurTeamPage(){
        return view('pageTeam');
    }

    public function JobDetails($id){
        $job = JobVacancy::where('id',$id)->first();
        $data= [
            'job'=>$job
        ];
        return view('pageJob',$data);
    }

    public function NewsDetails($id){
        $news = NewsArticle::where('id',$id)->first();
        $data= [
            'news'=>$news
        ];
        return view('pageThenews',$data);
    }

    public function ServicesPage(){
        return view('pageServices');
    }

    public function Coverage(){
        return view('pageCoverageMenu');
    }

    public function fiberstar_coverage(){
        $areas = AreaOutlineHeader::select(['id','city','kelurahan'])->whereRaw(
            'EXISTS(
                SELECT * FROM cities WHERE area_outline_headers.city = cities.name
            )AND
            EXISTS(
                SELECT * FROM kelurahans WHERE area_outline_headers.kelurahan = kelurahans.name
            )'
        )->with([
            'vertices' => function($query){
                $query->select('area_outline_header_id','latitude','longitude');
            }
        ])->get();

        $data = [];
        foreach ($areas as $area){
            $vertices = [];
            foreach ($area['vertices'] as $vertex){
                array_push($vertices,[$vertex['latitude'],$vertex['longitude']]);
            }

            $formatted = array(
                $area['city']."-".$area['kelurahan'] => $vertices
            );
            $data = array_merge($data,$formatted);
        }

        return response()->json(
            $data
            ,200
        );
    }

    public function show_fiberstar_coverage(){
//        $request = Request::create('/api/fiberstar-coverage','GET');
//        $outlines = Route::dispatch($request)->getContent();

        $outlines = $this->fiberstar_coverage()->getContent();
        $data = [
            'outlines' => $outlines
        ];
        return view('pageFiberStarCoverage',$data);
    }

    public function my_coverage_form(){
        $city = City::get();

        $data= [
            'cities' => $city
        ];

        return view('pageMyCoverage',$data);
    }

    public function TestCoverage(){
        return view('testcoverage');
    }
}

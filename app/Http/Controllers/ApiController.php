<?php

namespace App\Http\Controllers;

use App\AboutUsData;
use App\AreaOutlineHeader;
use App\City;
use App\ContactUsCC;
use App\CoveragePassThroughType;
use App\CoverageRequest;
use App\Kecamatan;
use App\Kelurahan;
use App\Mail\CoverageRequestMail;
use App\OurTeamSliderContent;
use App\BingMapApiKey;
use App\Coverage;
use App\JobVacancy;
use App\LandingPageData;
use App\Milestone;
use App\NewsArticle;
use App\Newsletter;
use App\OurTeamData;
use App\Service;
use App\SocialMedia;
use App\Street;
use App\Testimony;
use App\Webconfig;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class ApiController extends Controller
{
    public function main_data(){
        $webconfig = Webconfig::essentials()->orderBy('created_at','DESC')->first();

        if($webconfig==null){
            $webconfig = [];
            $webconfig['logo_image_link'] = config('placeholder.image_rectangle');
            $webconfig['company_name'] = config('placeholder.company_name');
            $webconfig['address'] = config('placeholder.short');
            $webconfig['phone'] = config('placeholder.phone');
            $webconfig['fax'] = config('placeholder.phone');
        }

        return response()->json($webconfig,200);
    }

    public function social_media(){
        $socmeds = SocialMedia::get();

        return response()->json(
            array(
                'socmeds' => $socmeds
            ),200);

    }

    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function landing_page_news(){
        $news = NewsArticle::landingpage()->orderBy('created_at','DESC')->take(2)->get();

        foreach ($news as $news_item){
            $news_item->date = Carbon::parse($news_item->date)->format("j-F-Y");
        }

        if($news==null){
            $news = [];
            for ($i = 0; $i < 6 ; $i++){
                $news_item = [];
                $news_item['image'] = config('placeholder.image_rectangle');
                $news_item['date'] = Carbon::now()->format("j-F-Y");
                $news_item['title'] = config('placeholder.very_short');
                $news_item['newsdesc'] = config('placeholder.short');
            }
        }
        else {
            foreach ($news as $news_item) {
                $article = strip_tags($news_item['newsdesc']);
                $index = strpos($article, '.');
                if ($index !== false) {
                    if($index <= 150){
                        $article = substr($article, 0, $index + 1) . '...';
                    }
                    else{
                        $substring = substr($article,0,150);
                        $spaceIdx = strrpos($substring, ' ');
                        if($spaceIdx!==false){
                            $article = substr($substring, 0, $spaceIdx) . '...';
                        }
                        else{
                            $article = substr($article, 0, 150) . '...';
                        }
                    }
                } else if (strlen($article) > 150) {
                    $article = substr($article, 0, 150) . '...';
                }
                $news_item['newsdesc'] = str_replace("&nbsp;","",$article);
            }
        }

        return response()->json(
            array(
                'news'=>$news
            ),200);
    }
    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function testimonials(){
        $testimonies = Testimony::essentials()->orderBy('created_at','DESC')->take(3)->get();

        if($testimonies==null){
            $testimonies = [];
            for($i = 0 ; $i < 3 ; $i++){
                $testimony = [];
                $testimony['image'] = config('placeholder.image_square');
                $testimony['name'] = config('placeholder.2_words');
                $testimony['testimonial'] = config('placeholder.medium');
                array_push($testimonies,$testimony);
            }
        }

        return response()->json(
            array(
                'testimonials'=>$testimonies
            ),200);
    }

    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
//    public function milestones(){
//        $milestones = Milestone::essentials()->orderBy('time','ASC')->get();
//
//        foreach ($milestones as $milestone){
//            $milestone->time = Carbon::parse($milestone->time)->format("F Y");
//        }
//
//        if($milestones==null){
//            $milestones = [];
//            for ($i = 0; $i < 7 ; $i++){
//                $milestone = [];
//                $milestone['time'] = Carbon::now()->format("F Y");
//                $milestone['image'] = config('placeholder.image_square');
//                $milestone['content'] = config('placeholder.medium');
//                array_push($milestones,$milestone);
//            }
//        }
//        return response()->json(
//            array(
//                'timeline'=>$milestones
//            )
//            ,200);
//    }

    public function milestones(){
        $milestones = Milestone::essentials()->orderBy('date','ASC')->get();
        $data = [];

        $temp = [];
        $temp['year'] = "";
        $temp['info'] = [];
        foreach ($milestones as $milestone){
            $tempyear = Carbon::parse($milestone->date)->format("Y");

            //if(temp's year != current data year and not null)
            if($temp["year"] != $tempyear && $temp["year"]!=""){
                array_push($data,$temp);
                $temp['year'] = "";
                $temp['info'] = [];
            }
            //if temp's year is null
            if($temp['year'] == ""){
                $temp['year'] = $tempyear;
            }
            //push current info to temp info
            $info = array(
                "image" => $milestone->image,
                "date" => Carbon::parse($milestone->date)->format("F Y"),
                "content" => $milestone->content
            );
            array_push($temp['info'],$info);
        }
        //push the last collection
        array_push($data,$temp);

//        if($milestones==null){
//            $milestones = [];
//            for ($i = 0; $i < 7 ; $i++){
//                $milestone = [];
//                $milestone['time'] = Carbon::now()->format("F Y");
//                $milestone['image'] = config('placeholder.image_square');
//                $milestone['content'] = config('placeholder.medium');
//                array_push($milestones,$milestone);
//            }
//        }
        return response()->json(
            array(
                'timeline'=>$data,
            )
            ,200);
    }

    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function services_page_content(){
        $services = Service::essentials()->get();

        if($services==null){
            $services = [];
            for($i = 0; $i < 3; $i++){
                $service = [];
                //
                array_push($services,$service);
            }
        }
        else{
            foreach ($services as $service){
                $advantages = $service->advantages;
                $advantages_array = [];
                foreach ($advantages as $advantage){
                    array_push($advantages_array,$advantage->advantage);
                }
                $service['strategy'] = $advantages_array;
                unset($service['id'],$service['advantages']);
            }
        }

        return response()->json(
            array(
                'services'=>$services
            ),200);
    }

    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function news(){
        $news = NewsArticle::essentials()->orderBy('created_at','DESC')->get();

        if($news==null){
            $news = [];

            for($i = 0 ; $i < 6; $i++){
                $news_item = [];
                $news_item['title'] = config('placeholder.very_short');
                $news_item['image'] = config('placeholder.rectangle');
                $news_item['newsdesc'] = config('placeholder.short');
            }
        }
        else {
            foreach ($news as $news_item) {
                $article = strip_tags($news_item['newsdesc']);
                $index = strpos($article, '.');
//                if ($index !== false) {
//                    $article = substr($article, 0, $index + 1) . '...';
//                } else if (strlen($article) > 100) {
//                    $article = substr($article, 0, 100) . '...';
//                }

                if ($index !== false) {
                    if($index <= 150){
                        $article = substr($article, 0, $index + 1) . '...';
                    }
                    else{
                            $substring = substr($article,0,150);
                            $spaceIdx = strrpos($substring, ' ');
                        if($spaceIdx!==false){
                            $article = substr($substring, 0, $spaceIdx) . '...';
                        }
                        else{
                            $article = substr($article, 0, 150) . '...';
                        }
                    }
                } else if (strlen($article) > 150) {
                    $article = substr($article, 0, 150) . '...';
                }

                $news_item['newsdesc'] = str_replace("&nbsp;","",$article);
            }
        }

        return response()->json(
            array(
                'news'=>$news
            ),200);
    }
    /**
     * Done
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function news_content($id){
        $details = NewsArticle::essentials()->where('id',$id)->first();

        return response()->json(
            array(
                'news'=>$details
            ),200);
    }
    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function newsletters(){
        $newsletters = Newsletter::essentials()->orderBy('created_at','DESC')->get();

        foreach ($newsletters as $newsletter){
            $newsletter['dateletter'] = Carbon::parse($newsletter->dateletter)->format('j F Y');
        }

        return response()->json(
            array(
                'newsletter'=>$newsletters
            ),200);
    }

    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function our_team_concerns(){
        $our_team = OurTeamData::essentials()->orderBy('created_at','DESC')->first();

        $concerns = [];
        for($i = 1; $i <= 3; $i++){
            $concern = [];
            $concern['number'] = $i;
            $concern['mconcern'] = $our_team['opportunity'.$i];
            array_push($concerns,$concern);
        }

        return response()->json(
            array(
                'ConcernBox'=>$concerns
            ),200);
    }
    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function our_team_slider(){
        $sliders = OurTeamSliderContent::essentials()->get();

        $data = [];
        if($sliders==null){
            for($i = 0 ; $i < 3 ; $i++){
                array_push($data,config('placeholder.image_rectangle'));
            }
        }
        else{
            foreach ($sliders as $slider){
                array_push($data,$slider->media_link);
            }
        }
        return response()->json(
            array(
                'ImgSlides'=>$data
            ),200);
    }
    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function job_vacancies(){
        $jobs = JobVacancy::brief()->get();

        return response()->json(
            array(
                'jobslist'=>$jobs
            ),200);
    }
    /**
     * Done
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function job_vacancy_content($id){
        $job = JobVacancy::essentials()->where('id',$id)->first();

        return response()->json(array('jobs'=>$job),200);
    }

    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function landing_page_content(){
        $landing_page = LandingPageData::essentials()->orderby('created_at','DESC')->first();

        //fill with mock data if no data
        if($landing_page==null){
            $landing_page = [];
            $landing_page['background_image_link'] = config('placeholder.image_rectangle');
            $landing_page['who_we_are'] = config('placeholder.long');
            $landing_page['benefits'] = array(
                array('title'=>config('placeholder.2_words'),'description'=>config('placeholder.short'),'image'=>config('placeholder.image_square')),
                array('title'=>config('placeholder.2_words'),'description'=>config('placeholder.short'),'image'=>config('placeholder.image_square')),
                array('title'=>config('placeholder.2_words'),'description'=>config('placeholder.short'),'image'=>config('placeholder.image_square')),
                array('title'=>config('placeholder.2_words'),'description'=>config('placeholder.short'),'image'=>config('placeholder.image_square')),
            );
        }
        else{
            $landing_page['benefits'] =
                array(
                    array('title'=>$landing_page['benefit1_title'],'description'=>$landing_page['benefit1_description'],'image'=>$landing_page['benefit1_image_link']),
                    array('title'=>$landing_page['benefit2_title'],'description'=>$landing_page['benefit2_description'],'image'=>$landing_page['benefit2_image_link']),
                    array('title'=>$landing_page['benefit3_title'],'description'=>$landing_page['benefit3_description'],'image'=>$landing_page['benefit3_image_link']),
                    array('title'=>$landing_page['benefit4_title'],'description'=>$landing_page['benefit4_description'],'image'=>$landing_page['benefit4_image_link']),
                );
            unset(
                $landing_page['benefit1_title'],$landing_page['benefit2_title'],$landing_page['benefit3_title'],$landing_page['benefit4_title'],
                $landing_page['benefit1_description'],$landing_page['benefit2_description'],$landing_page['benefit3_description'],$landing_page['benefit4_description'],
                $landing_page['benefit1_image_link'],$landing_page['benefit2_image_link'],$landing_page['benefit3_image_link'],$landing_page['benefit4_image_link']
            );
        }
        return response()->json( $landing_page,200);
    }
    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function about_us_page_content(){
        $about_us = AboutUsData::essentials()->orderBy('created_at','DESC')->first();


        if($about_us==null){
            $about_us = [];
            $about_us['imagestar'] = config('placeholder.long');
            $about_us['boxtwo'] = config('placeholder.image_rectangle');
            $about_us['vision'] =config('placeholder.short');
            $about_us['mission'] = config('placceholder.short');
        }

        return response()->json(
            array(
                'imagestar'=>$about_us['imagestar'],
                'boxtwo'=>$about_us['boxtwo'],
                'vision'=>$about_us['vision'],
                'mission'=>$about_us['mission'],
            ),200);
    }

    /**
     * Done
     * @return \Illuminate\Http\JsonResponse
     */
    public function news_page_content(){
        $data = [
            'news' => $this->news()->original['news'],
            'newsletter' => $this->newsletters()->original['newsletter']
        ];

        return response()->json($data,200);
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

    public function get_cities(){
        $cities = City::get();
        return response()->json(
            array(
                'cities'=>$cities
            )
            ,200);
    }
    public function get_kecamatans($id){
        $kecamatans = Kecamatan::where('city_id',$id)->get();
        return response()->json(
            $kecamatans
            ,200);
    }
    public function get_kelurahans($id){
        $kelurahans = Kelurahan::where('kecamatan_id',$id)->get();
        return response()->json(
            $kelurahans
            ,200);
    }
    public function get_roads($id){
        $roads = Street::where('kelurahan_id',$id)->get();
        return response()->json(
            $roads
            ,200);
    }

    /**
     * TOBE IMPLEMENTED
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create_coverage_request(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'phone_no' => 'required',
            'email' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()->all()]);
        }

//        $this->validate($request, [
//            'name' => 'required',
//            'phone_no' => 'required',
//            'email' => 'required',
//            'city' => 'required',
//            'district' => 'required',
//            'subdistrict' => 'required',
//            'postal_code' => 'required',
//            'latitude' => 'required',
//            'longitude' => 'required',
//        ]);

        $crequest = new CoverageRequest();
        $crequest->name = $request->name;
        $crequest->phone_no = $request->phone_no;
        $crequest->email = $request->email;
        $crequest->city = $request->city;
        $crequest->district = $request->district;
        $crequest->subdistrict = $request->subdistrict;
        $crequest->postal_code = $request->postal_code;
        $crequest->street = $request->street;
        $crequest->latitude = floatval($request->latitude);
        $crequest->longitude = floatval($request->longitude);
        $crequest->save();

        $webconfig = Webconfig::orderBy('created_at','DESC')->first();
        $ccs = [];
        $mails = ContactUsCC::get();
        foreach ($mails as $mail){
            array_push($ccs,$mail->email);
        }

        Mail::to($webconfig->contact_email)->cc($ccs)->send( new CoverageRequestMail($crequest));

        return response()->json(
            array(
                'request'=>$crequest
            )
            ,200);
    }

    /**
     * Unused
     * @return \Illuminate\Http\JsonResponse
     */
    public function our_team_page_content(){
        $our_team = OurTeamData::essentials()->orderBy('created_at','DESC')->first();
        $our_team['job vacancies'] = $this->job_vacancies()->original;

        return response()->json($our_team,200);
    }

    /**
     * Unused
     * @return \Illuminate\Http\JsonResponse
     */
    public function coverage_data(){
        $coverages = Coverage::essentials()->get();
        foreach ($coverages as $coverage){
            $coverage['pass through type'] = $coverage->type->pass_through_type;
            unset($coverage['type'],$coverage['pass_through_type_id']);
        }

        $terrestrial= [];
        $hybrid =[];
        $submarine =[];

        foreach($coverages as $coverage){
            if(strtolower($coverage['pass through type']) == "terrestrial"){
                unset($coverage['id'],$coverage['pass through type']);
                array_push($terrestrial,$coverage);
            }
            else if(strtolower($coverage['pass through type']) == "submarine"){
                unset($coverage['id'],$coverage['pass through type']);
                array_push($submarine,$coverage);
            }
            else if(strtolower($coverage['pass through type']) == "hybrid") {
                unset($coverage['id'],$coverage['pass through type']);
                array_push($hybrid,$coverage);
            }
        }

        $apikey = BingMapApiKey::where('in_use',1)->first();
        $apikey->in_use = 0;
        $apikey->save();

        $nextapikey = BingMapApiKey::where('fetch_order',$apikey->fetch_order + 1)->first();
        //check if there is no next order
        if($nextapikey==null){
            $nextapikey = BingMapApiKey::where('fetch_order',1)->first();
        }
        //check if any key exists at all
        if($nextapikey!= null){
            $nextapikey->in_use = 1;
            $nextapikey->save();
        }

        return response()->json(
            array(
                'terrestrial'=>$terrestrial,
                'submarine' => $submarine,
                'hybrid' => $hybrid,
                'api key'=>$apikey->api_key
            ),200);
    }
}

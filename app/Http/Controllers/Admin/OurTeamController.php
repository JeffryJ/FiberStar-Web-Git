<?php

namespace App\Http\Controllers\Admin;

use App\OurTeamData;
use App\OurTeamSliderContent;
use App\Rules\ValidYoutubeLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class OurTeamController extends Controller
{
    public function our_team_index(){

        $our_team = OurTeamData::orderBy('created_at','DESC')->first();

        $images = OurTeamSliderContent::get();

        $data = [
            'images' => $images
        ];

        if($our_team!=null){
            $data = array_merge($data,['data'=>$our_team]);
        }
        return view('admin/our_team/our_team_index',$data);
    }

    public function update_our_team(Request $request){
        $this->validate($request, [
            'opportunity1' => 'required',
            'opportunity2' => 'required',
            'opportunity3' => 'required',
        ]);

        $data = new OurTeamData();
        $data->opportunity1 = $request->opportunity1;
        $data->opportunity2 = $request->opportunity2;
        $data->opportunity3 = $request->opportunity3;
        $data->save();

        return redirect('admin/our-team');
    }

    public function add_slider_content(Request $request){

        $this->validate($request, [
            'youtube_url' => ['required_without:media_images', new ValidYoutubeLink()],
            'media_images' => 'required_without:youtube_url',
            'media_images.*' => 'mimes:jpg,jpeg,bmp,png'
        ]);

        if($request->media_type == "youtube_url"){
            $media = new OurTeamSliderContent();
            $media->media_link = ConvertToEmbedUrl($request->youtube_url);
            $media->save();
        }
        else if($request->media_type == "image"){
            $files = $request->file('media_images');
            $i = 0;
            foreach ( $files as $file){
                $media = new OurTeamSliderContent();

                $image = Image::make($file)->encode('jpg',70);

                $filename = 'otsi-'.time().$i.'.jpg';
                Storage::put('public/our-team/slider/'.$filename, (string)$image);
                $image->destroy();

                $media->media_link = 'storage/our-team/slider/'.$filename;
                $media->save();
                $i++;
            }
        }

        return redirect('admin/our-team#slider-content-form');
    }

    public function delete_slider_content(Request $request){

        $media = OurTeamSliderContent::where('id',$request->id)->first();

        if($media!=null){
            if(strpos($media->media_link , 'youtube') === false){
                Storage::delete('public/our-team/slider/'.$media->media_link);
            }
            $media->delete();
        }

        return redirect('admin/our-team#slider-gallery');
    }
}

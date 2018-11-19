<?php

namespace App\Http\Controllers\Admin;

use App\LandingPageData;
use App\LandingPageSliderContent;
use App\Rules\ValidYoutubeLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;


class LandingPageController extends Controller
{
    public function landing_page_index(){
        $LDData = LandingPageData::orderBy('created_at','DESC')->first();
        $images = LandingPageSliderContent::get();

        $data = [
            'images' => $images
        ];

        if($LDData!=null){
            $data = array_merge($data,['data' => $LDData]);
        }

        return view('admin/landing_page/landing_page_index',$data);
    }

    public function update_landing_page(Request $request){

        $this->validate($request, [
            'background_image' => 'mimes:jpg,jpeg,bmp,png',
            'background_image_filename' => 'required',
            'who_we_are' => 'required',
            'benefit1_title' => 'required',
            'benefit1_description' => 'required',
            'benefit1_image' => 'mimes:jpg,jpeg,bmp,png',
            'benefit1_filename' => 'required',
            'benefit2_title' => 'required',
            'benefit2_description' => 'required',
            'benefit2_image' => 'mimes:jpg,jpeg,bmp,png',
            'benefit2_filename' => 'required',
            'benefit3_title' => 'required',
            'benefit3_description' => 'required',
            'benefit3_image' => 'mimes:jpg,jpeg,bmp,png',
            'benefit3_filename' => 'required',
            'benefit4_title' => 'required',
            'benefit4_description' => 'required',
            'benefit4_image' => 'mimes:jpg,jpeg,bmp,png',
            'benefit4_filename' => 'required',
        ],
        [
            'background_image_filename.required' => 'The image field is required.',
            'benefit1_filename.required' => 'The image field is required.',
            'benefit2_filename.required' => 'The image field is required.',
            'benefit3_filename.required' => 'The image field is required.',
            'benefit4_filename.required' => 'The image field is required.'
        ]);

        $data = new LandingPageData();
        $data->who_we_are = $request->who_we_are;
        $data->benefit1_title = $request->benefit1_title;
        $data->benefit1_description = $request->benefit1_description;
        $data->benefit2_title = $request->benefit2_title;
        $data->benefit2_description = $request->benefit2_description;
        $data->benefit3_title = $request->benefit3_title;
        $data->benefit3_description = $request->benefit3_description;
        $data->benefit4_title = $request->benefit4_title;
        $data->benefit4_description = $request->benefit4_description;

        $old = LandingPageData::where('id',$request->id)->first();

        if($request->hasFile('background_image')){
            $image = Image::make($request->file('background_image'))->encode('png');
            $filename = 'bgi-'.time().'1'.'.png';
            Storage::put('public/landing-page/background/'.$filename, (string)$image);

            $data->background_image_link = 'storage/landing-page/background/'.$filename;
            $image->destroy();
        }
        else{
            $data->background_image_link = $old->background_image_link;
        }

        if($request->hasFile('benefit1_image')){
            $image = Image::make( $request->file('benefit1_image'))->encode('png');
            $filename = 'bi-'.time().'2'.'.png';
            Storage::put('public/landing-page/benefits/'.$filename, (string)$image);

            $data->benefit1_image_link = 'storage/landing-page/benefits/'.$filename;
            $image->destroy();
        }
        else{
            $data->benefit1_image_link = $old->benefit1_image_link;
        }

        if($request->hasFile('benefit2_image')){
            $image = Image::make( $request->file('benefit2_image'))->encode('png');
            $filename = 'bi-'.time().'3'.'.png';
            Storage::put('public/landing-page/benefits/'.$filename, (string)$image);

            $data->benefit2_image_link =  'storage/landing-page/benefits/'.$filename;
            $image->destroy();
        }
        else{
            $data->benefit2_image_link = $old->benefit2_image_link;
        }

        if($request->hasFile('benefit3_image')){
            $image = Image::make( $request->file('benefit3_image'))->encode('png');
            $filename = 'bi-'.time().'4'.'.png';
            Storage::put('public/landing-page/benefits/'.$filename, (string)$image);

            $data->benefit3_image_link =  'storage/landing-page/benefits/'.$filename;
            $image->destroy();
        }
        else{
            $data->benefit3_image_link = $old->benefit3_image_link;
        }

        if($request->hasFile('benefit4_image')){
            $image = Image::make( $request->file('benefit4_image'))->encode('png');
            $filename = 'bi-'.time().'5'.'.png';
            Storage::put('public/landing-page/benefits/'.$filename, (string)$image);

            $data->benefit4_image_link =  'storage/landing-page/benefits/'.$filename;
            $image->destroy();
        }
        else{
            $data->benefit4_image_link = $old->benefit4_image_link;
        }

        $data->save();

        return redirect('admin/landing-page');
    }

    public function add_slider_content(Request $request){

        $this->validate($request, [
            'youtube_url' => ['required_without:media_images', new ValidYoutubeLink()],
            'media_images' => 'required_without:youtube_url',
            'media_images.*' => 'mimes:jpg,jpeg,bmp,png'
        ]);

        if($request->media_type == "youtube_url"){
            $media = new LandingPageSliderContent();
            $media->media_link = ConvertToEmbedUrl($request->youtube_url);
            $media->save();
        }
        else if($request->media_type == "image"){
            $files = $request->file('media_images');
            $i = 0;
            foreach ( $files as $file){
                $media = new LandingPageSliderContent();

//                $image = Image::make($file)->encode('jpg',70);
//                $filename = 'lpsi-'.time().$i.'.jpg';

                $image = Image::make($file)->encode('png');
                $filename = 'lpsi-'.time().$i.'.png';

                Storage::put('public/landing-page/slider/'.$filename, (string)$image);
                $image->destroy();

                $media->media_link =  'storage/landing-page/slider/'.$filename;
                $media->save();
                $i++;
            }
        }

        return redirect('admin/landing-page#slider-content-form');
    }

    public function delete_slider_content(Request $request){

        $media = LandingPageSliderContent::where('id',$request->id)->first();

        if($media!=null){
            if(strpos($media->media_link , 'youtube') === false){
                Storage::delete('public/landing-page/slider/'.$media->media_link);
            }
            $media->delete();
        }

        return redirect('admin/landing-page#slider-content-form');
    }
}

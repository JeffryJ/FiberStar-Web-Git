<?php

namespace App\Http\Controllers\Admin;

use App\AboutUsData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class AboutUsController extends Controller
{
    public function about_us_index(){
        $aboutUs = AboutUsData::orderBy('created_at','DESC')->first();

        if($aboutUs!=null){
            $data = [
                'data' => $aboutUs
            ];

            return view('admin/about_us/about_us_index',$data);
        }
        else{
            return view('admin/about_us/about_us_index');
        }

    }

    public function update_about_us(Request $request){
        $this->validate($request, [
            'vision' => 'required',
            'mission' => 'required',
            'corporate_values_description' => 'required',
            'corporate_values_image' => 'mimes:jpg,jpeg,bmp,png',
            'corporate_values_filename' => 'required'
        ],[
            'corporate_values_filename.required' => 'The image field is required.'
        ]);

        $data = new AboutUsData();
        $data->vision = $request->vision;
        $data->mission = $request->mission;
        $data->corporate_values_description = $request->corporate_values_description;

        $old = AboutUsData::where('id',$request->id)->first();

        if($request->hasFile('corporate_values_image')){
            $image = Image::make( $request->file('corporate_values_image'))->encode('png');
            $filename = 'cvi-'.time().'.png';
            Storage::put('public/about-us/'.$filename, (string)$image);

            $data->corporate_values_image_link = 'storage/about-us/'.$filename;
        }
        else{
            $data->corporate_values_image_link = $old->corporate_values_image_link;
        }

        $data->save();

        return redirect('admin/about-us');
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Testimony;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class TestimonyController extends Controller
{
    public function testimonies_index(){

        $testimonies = Testimony::orderBy('created_at','DESC')->get();

        $data = [
            'testimonies' => $testimonies
        ];

        return view('admin/testimonies/testimonies_index',$data);
    }

    public function add_testimony_form(){

        $data=[
            'title' => 'Add Testimony'
        ];

        return view('admin/testimonies/testimony_form', $data);
    }

    public function add_testimony(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'title' => 'required',
            'testimony' => 'required',
            'image' => 'mimes:jpg,jpeg,bmp,png|required'
        ]);

        $testimony = new Testimony();
        $testimony->name = $request->name;
        $testimony->title = $request->title;
        $testimony->testimony = $request->testimony;

        $image = Image::make( $request->file('image'))->encode('png');

        $filename = 'ti-'.time().'.png';
        Storage::put('public/testimonies/'.$filename, (string)$image);

        $testimony->image_link = 'storage/testimonies/'.$filename;
        $testimony->save();

        return redirect('admin/testimonies');
    }

    public function edit_testimony_form($id){
        $testimony = Testimony::where('id',$id)->first();

        $data=[
            'testimony' => $testimony,
            'title' => 'Edit Testimony'
        ];

        return view('admin/testimonies/testimony_form',$data);
    }

    public function edit_testimony(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'title' => 'required',
            'testimony' => 'required',
            'image' => 'mimes:jpg,jpeg,bmp,png',
            'readonly-filename' => 'required'
        ],
            [
                'readonly-filename.required' => 'image field is required'
            ]);

        $testimony = Testimony::where('id',$request->id)->first();

        $testimony->name = $request->name;
        $testimony->title = $request->title;
        $testimony->testimony = $request->testimony;

        if($request->hasFile('image')){
            Storage::delete('public/testimonies/'.$testimony->image_link);

            $image = Image::make( $request->file('image'))->encode('png');
            $filename = 'ni-'.time().'.png';
            Storage::put('public/testimonies/'.$filename, (string)$image);

            $testimony->image_link = 'storage/testimonies/'.$filename;
        }

        $testimony->save();

        return redirect('admin/testimonies');
    }

    public function delete_testimony(Request $request){

        $testimony = Testimony::where('id',$request->id)->first();

        if($testimony!=null){
            Storage::delete('public/testimonies/'.$testimony->image_link);
            $testimony->delete();
        }

        return redirect('admin/testimonies');
    }
}

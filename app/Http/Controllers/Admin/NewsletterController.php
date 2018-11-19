<?php

namespace App\Http\Controllers\Admin;

use App\Newsletter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class NewsletterController extends Controller
{
    public function newsletter_index(){
        $newsletters = Newsletter::get();

        $data = [
            'newsletters' => $newsletters
        ];

        return view('admin/newsletter/newsletter_index',$data);
    }

    public function add_newsletter_form(){
        $data = [
            'title' => 'Add Newsletter'
        ];

        return view('admin/newsletter/newsletter_form',$data);
    }

    public function add_newsletter(Request $request){

        $this->validate($request, [
            'volume' => 'required',
            'image' => 'mimes:jpg,jpeg,bmp,png|required'
        ]);

        $newsletter = new Newsletter();
        $newsletter->volume = $request->volume;

        $image = Image::make( $request->file('image'))->encode('jpg',90);
        $filename = "nli-".time().".jpg";
        Storage::put('public/newsletter/'.$filename, (string)$image);

        $newsletter->image_link = 'storage/newsletter/'.$filename;
        $newsletter->save();

        return redirect('admin/newsletter');
    }

    public function edit_newsletter_form($id){
        $newsletter =Newsletter::where('id',$id)->first();

        $data = [
            'newsletter' => $newsletter,
            'title' => 'Edit Newsletter'
        ];

        return view('admin/newsletter/newsletter_form',$data);
    }

    public function edit_newsletter(Request $request){
        $this->validate($request, [
            'volume' => 'required',
            'image' => 'mimes:jpg,jpeg,bmp,png',
            'readonly-filename' => 'required'
        ],
        [
            'readonly-filename.required' => 'Image field is required'
        ]);

        $newsletter = Newsletter::where('id',$request->id)->first();

        $newsletter->volume = $request->volume;

        if($request->hasFile('image')){

            Storage::delete('public/newsletter/'.$newsletter->image_link);

            $image = Image::make( $request->file('image'))->encode('jpg',90);
            $filename = "nli-".time().".jpg";
            Storage::put('public/newsletter/'.$filename, (string)$image);

            $newsletter->image_link = 'storage/newsletter/'.$filename;
        }
        $newsletter->save();

        return redirect('admin/newsletter');
    }

    public function delete_newsletter(Request $request){
        $newsletter = Newsletter::where('id',$request->id)->first();

        if($newsletter!=null){
            Storage::delete('public/newsletter/'.$newsletter->image_link);
            $newsletter->delete();
        }

        return redirect('/admin/newsletter');
    }
}

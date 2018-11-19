<?php

namespace App\Http\Controllers\Admin;

use App\Milestone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class MilestonesController extends Controller
{
    public function milestones_index(){
        $milestones = Milestone::orderBy('date','DESC')->get();

        $data = [
            'milestones' => $milestones
        ];

        return view('admin/milestones/milestones_index', $data);
    }

    public function add_milestone_form(){
        $data = [
            'title' => 'Add Milestone'
        ];

        return view('admin/milestones/milestone_form', $data);
    }

    public function add_milestone(Request $request){
        $this->validate($request, [
            'date' => 'required',
            'description' => 'required',
            'image' => 'mimes:jpg,jpeg,bmp,png|required'
        ]);

        $milestone = new Milestone();
        $milestone->date = $request->date;
        $milestone->description = $request->description;

        $image = Image::make( $request->file('image'))->encode('png');

        $filename = 'mi-'.time().'.png';
        Storage::put('public/milestones/'.$filename, (string)$image);

        $milestone->image_link = 'storage/milestones/'.$filename;
        $milestone->save();

        return redirect('admin/milestones');
    }

    public function edit_milestone_form($id){
        $milestone = Milestone::where('id',$id)->first();

        $data = [
            'title' => 'Add Milestone',
            'milestone' => $milestone
        ];

        return view('admin/milestones/milestone_form', $data);
    }

    public function edit_milestone(Request $request){
        $this->validate($request, [
            'description' => 'required',
            'date' => 'required',
            'image' => 'mimes:jpg,jpeg,bmp,png',
            'readonly-filename' => 'required'
        ],
        [
            'readonly-filename.required' => 'image field is required'
        ]);

        $milestone = Milestone::where('id',$request->id)->first();
        $milestone->date = $request->date;
        $milestone->description = $request->description;

        if($request->hasFile('image')){
            Storage::delete('public/milestones/'.$milestone->image_link);

            $image = Image::make( $request->file('image'))->encode('png');
            $filename = 'mi-'.time().'.png';
            Storage::put('public/milestones/'.$filename, (string)$image);

            $milestone->image_link = 'storage/milestones/'.$filename;
        }
        $milestone->save();

        return redirect('admin/milestones');
    }

    public function delete_milestone(Request $request){
        $milestone = Milestone::where('id',$request->id)->first();

        if($milestone!=null){
            Storage::delete('public/milestones/'.$milestone->image_link);
            $milestone->delete();
        }

        return redirect('admin/milestones');
    }
}

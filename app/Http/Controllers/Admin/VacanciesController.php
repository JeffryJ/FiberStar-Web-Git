<?php

namespace App\Http\Controllers\Admin;

use App\JobVacancy;
use App\Rules\QuillRequired;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class VacanciesController extends Controller
{
    public function vacancies_index(){
        $vacancies= JobVacancy::get();

        foreach ($vacancies as $vacancy){
            $qualifications = strip_tags($vacancy->qualifications);
            if(strlen($qualifications) > 150){
                $qualifications = substr($qualifications,0,150).'...';
            }
            $vacancy->qualifications = $qualifications;

            $responsibilities = strip_tags($vacancy->responsibilities);
            if(strlen($responsibilities) > 150){
                $responsibilities = substr($responsibilities,0,150).'...';
            }
            $vacancy->responsibilities = $responsibilities;
        }

        $data = [
            'vacancies' => $vacancies
        ];

        return view('admin/job_vacancies/vacancies_index',$data);
    }

    public function add_vacancy_form(){

        $data = [
            'title' => 'Add Vacancy'
        ];

        return view('admin/job_vacancies/vacancy_form', $data);
    }

    public function add_vacancy(Request $request){

        $this->validate($request, [
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'location' => 'required',
            'renumeration' => 'required',
            'qualifications' => ['required', new QuillRequired()],
            'responsibilities' => ['required', new QuillRequired()],
            'image' => 'mimes:jpg,jpeg,bmp,png|required'
        ]);

        $job = new JobVacancy();
        $job->job_title = $request->title;
        $job->start_date = $request->start_date;
        $job->end_date = $request->end_date;
        $job->location = $request->location;
        $job->renumeration = $request->renumeration;
        $job->qualifications = $request->qualifications;
        $job->responsibilities = $request->responsibilities;

        $image = Image::make( $request->file('image'))->encode('png');

        $filename = 'vi-'.time().'.png';
        Storage::put('public/job-vacancies/'.$filename, (string)$image);

        $job->image_link = 'storage/job-vacancies/'.$filename;
        $job->save();

        return redirect('/admin/job-vacancies');
    }

    public function edit_vacancy_form($id){

        $job = JobVacancy::where('id',$id)->first();

        $data = [
            'title' => 'Edit Vacancy',
            'vacancy' => $job
        ];

        return view('admin/job_vacancies/vacancy_form', $data);
    }

    public function edit_vacancy(Request $request){

        $this->validate($request, [
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'location' => 'required',
            'renumeration' => 'required',
            'qualifications' => ['required', new QuillRequired()],
            'responsibilities' => ['required', new QuillRequired()],
            'image' => 'mimes:jpg,jpeg,bmp,png',
            'readonly-filename' => 'required'
        ],
        [
            'readonly-filename.required' => 'image field is required'
        ]);

        $job = JobVacancy::where('id',$request->id)->first();

        $job->job_title = $request->title;
        $job->start_date = $request->start_date;
        $job->end_date = $request->end_date;
        $job->location = $request->location;
        $job->renumeration = $request->renumeration;
        $job->qualifications = $request->qualifications;
        $job->responsibilities = $request->responsibilities;

        if($request->hasFile('image')){
            Storage::delete('public/job-vacancies/'.$job->image_link);

            $image = Image::make( $request->file('image'))->encode('png');
            $filename = 'vi-'.time().'.png';
            Storage::put('public/job-vacancies/'.$filename, (string)$image);

            $job->image_link = 'storage/job-vacancies/'.$filename;
        }

        $job->save();

        return redirect('admin/job-vacancies');
    }

    public function delete_vacancy(Request $request){
        $job = JobVacancy::where('id',$request->id)->first();

        if($job!=null){
            Storage::delete('public/job-vacancies/'.$job->image_link);
            $job->delete();
        }

        return redirect('admin/job-vacancies');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\NewsArticle;
use App\Rules\QuillRequired;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class NewsController extends Controller
{
    public function news_index(){

        $news = NewsArticle::orderBy('created_at','DESC')->get();

        foreach ($news as $news_item){
            $article = strip_tags($news_item->article);
            if(strlen($article) > 150){
                $article = substr($article,0,150).'...';
            }
            $news_item->article = $article;
        }

        $data = [
            'articles' => $news
        ];

        return view('admin/news/news_index',$data);
    }

    public function add_news_form(){

        $data=[
            'title' => 'Add News'
        ];

        return view('admin/news/news_form', $data);
    }

    public function add_news(Request $request){

        $this->validate($request, [
            'title' => 'required',
            'article' => ['required', new QuillRequired()],
            'image' => 'mimes:jpg,jpeg,bmp,png|required'
        ]);

        $data = new NewsArticle();
        $data->news_title = $request->title;
        $data->article = $request->article;

        $image = Image::make( $request->file('image'))->encode('png');

        $filename = 'ni-'.time().'.png';
        Storage::put('public/news/'.$filename, (string)$image);

        $data->image_link = 'storage/news/'.$filename;
        $data->save();

        return redirect('admin/news');
    }

    public function edit_news_form($id){
        $article = NewsArticle::where('id',$id)->first();

        $data=[
            'article' => $article,
            'title' => 'Edit News'
        ];

        return view('admin/news/news_form',$data);
    }

    public function edit_news(Request $request){

        $this->validate($request, [
            'title' => 'required',
            'article' => ['required', new QuillRequired()],
            'image' => 'mimes:jpg,jpeg,bmp,png',
            'readonly-filename' => 'required'
        ],
        [
            'readonly-filename.required' => 'image field is required'
        ]);

        $data = NewsArticle::where('id',$request->id)->first();

        $data->news_title = $request->title;
        $data->article = $request->article;

        if($request->hasFile('image')){
            Storage::delete('public/news/'.$data->image_link);

            $image = Image::make( $request->file('image'))->encode('png');
            $filename = 'ni-'.time().'.png';
            Storage::put('public/news/'.$filename, (string)$image);

            $data->image_link = 'storage/news/'.$filename;
        }

        $data->save();

        return redirect('admin/news');
    }

    public function delete_news(Request $request){

        $data = NewsArticle::where('id',$request->id)->first();

        if($data!=null){
            Storage::delete('public/news/'.$data->image_link);
            $data->delete();
        }

        return redirect('admin/news');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\BingMapApiKey;
use App\ContactUsCC;
use App\Rules\QuillRequired;
use App\Rules\ValidPhoneNumber;
use App\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Webconfig;
use Illuminate\Support\Facades\Storage;
use Image;

class WebConfigController extends Controller
{
    public function webconfig_index(){
        $webconfig = Webconfig::orderBy('created_at','DESC')->first();

        $socmeds = SocialMedia::get();

        $apikeys = BingMapApiKey::get();

        $ccs = ContactUsCC::get();

        if($webconfig!=null){
            $data = [
                'data' => $webconfig,
                'socmeds' => $socmeds,
                'apikeys' =>$apikeys,
                'ccs' => $ccs
            ];

            return view('admin.webconfig.webconfig_index', $data);
        }
        else{
            return view('admin.webconfig.webconfig_index');
        }

    }

    public function update_webconfig(Request $request){
        $this->validate($request,[
            'logo_image' => 'mimes:jpg,jpeg,bmp,png',
            'logo_filename' => 'required',
            'cuscare_image' => 'mimes:jpg,jpeg,bmp,png',
            'cuscare_filename' => 'required',
            'company_name' => 'required',
            'address' => ['required',new QuillRequired()],
            'phone' => ['required',new ValidPhoneNumber() ],
            'fax' => ['required', new ValidPhoneNumber() ],
            'contact_email' => 'required|email',
            'ccs.*' => 'email'
        ],[
            'ccs.*.email' => 'CC must be a valid email address.'
        ]);

        $data = new Webconfig();
        $data->company_name = $request->company_name;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->fax = $request->fax;
        $data->contact_email = $request->contact_email;

        $old = Webconfig::orderBy('created_at','DESC')->first();
        if($request->hasFile('logo_image')){
            $image = Image::make( $request->file('logo_image'))->encode('png');
            $filename = 'logo-'.time().'.png';
            Storage::put('public/web/'.$filename, (string)$image);

            $data->logo_image_link = 'storage/web/'.$filename;
        }
        else{
            $data->logo_image_link = $old->logo_image_link;
        }
        if($request->hasFile('cuscare_image')){
            $image = Image::make( $request->file('cuscare_image'))->encode('png');
            $filename = 'customercare-'.time().'.png';
            Storage::put('public/web/'.$filename, (string)$image);

            $data->customer_care_image_link = 'storage/web/'.$filename;
        }
        else{
            $data->customer_care_image_link = $old->customer_care_image_link;
        }

        $ids = json_decode($request->to_be_deleted);
        if($ids != null){
            foreach ($ids as $id){
                if($id!=0) {
                    ContactUsCC::where('id', $id)->delete();
                }
            }
        }
        if($request->has('cc_ids')){
            $index = 0;
            foreach ($request->cc_ids as $id){
                if($id == 0){
                    if($request->ccs[$index] !=""){
                        $cc = new ContactUsCC();
                        $cc->email = $request->ccs[$index];
                        $cc->save();
                    }
                }
                else{
                    if($request->ccs[$index !=""]){
                        $cc = ContactUsCC::where('id',$id)->first();
                        $cc->email = $request->ccs[$index];
                        $cc->save();
                    }
                    else{
                        $cc = ContactUsCC::where('id',$id)->first();
                        $cc->delete();
                    }
                }
                $index++;
            }
        }

        $data->save();

        return redirect('admin/webconfig')->with('success','Successfully updated.');
    }

    public function add_social_media_modal(){
        $data = [
            'title' => 'Add Social Media'
        ];

        return view('admin.webconfig.social_media_modal',$data);
    }

    public function add_social_media(Request $request){
        $this->validate($request, [
            'url' => 'required|url',
            'icon' => 'mimes:jpg,jpeg,bmp,png|required'
        ]);

        $socmed = new SocialMedia();
        $socmed->url = $request->url;

        $image = Image::make( $request->file('icon'))->encode('png');
        $filename = "smi-".time().".png";
        Storage::put('public/web/social-media/'.$filename, (string)$image);
        $socmed->icon_image_link = 'storage/web/social-media/'.$filename;

        $socmed->save();

        return redirect('admin/webconfig');
    }

    public function edit_social_media_modal($id){
        $socmed = SocialMedia::where('id',$id)->first();

        $data=[
            'title' => 'Edit Social Media',
            'social_media' => $socmed
        ];

        return view('admin.webconfig.social_media_modal',$data);
    }

    public function edit_social_media(Request $request){
        $this->validate($request, [
            'url' => 'required',
            'icon' => 'mimes:jpg,jpeg,bmp,png',
            'icon-filename' => 'required',
        ],[
            'icon-filename.required' => 'Image field is required.'
        ]);

        $socmed = SocialMedia::where('id', $request->id)->first();
        $socmed->url = $request->url;

        if($request->hasFile('icon')){

            Storage::delete('public/web/social-media/'.$socmed->icon_image_link);

            $image = Image::make( $request->file('icon'))->encode('png');
            $filename = "smi-".time().".png";
            Storage::put('public/web/social-media/'.$filename, (string)$image);

            $socmed->icon_image_link = 'storage/web/social-media/'.$filename;
        }
        $socmed->save();

        return redirect('admin/webconfig');
    }

    public function delete_social_media(Request $request){
        $socmed = SocialMedia::where('id', $request->id)->first();

        if($socmed!=null){
            Storage::delete('public/web/social-media/'.$socmed->icon_image_link);
            $socmed->delete();
        }
        return redirect('admin/webconfig');
    }

    public function add_bing_api_key_modal(){
        $data = [
            'title' => 'Add Bing API Key'
        ];

        return view('admin.webconfig.bing_api_key_modal',$data);
    }

    public function add_bing_api_key(Request $request){

        $this->validate($request,[
            'api_key' => 'required',
        ]);

        $apikey = new BingMapApiKey();
        $apikey->api_key = $request->api_key;

        $lastkey = BingMapApiKey::orderBy('fetch_order','DESC')->first();
        if($lastkey!=null){
            $apikey->fetch_order = $lastkey->fetch_order + 1;
        }
        else{
            $apikey->fetch_order = 1;
            $apikey->in_use = 1;
        }

        $apikey->save();

        return redirect('admin/webconfig');
    }

    public function edit_bing_api_key_modal($id){
        $apikey = BingMapApiKey::where('id',$id)->first();

        $data = [
            'title' => 'Add Bing API Key',
            'apikey' => $apikey
        ];

        return view('admin.webconfig.bing_api_key_modal',$data);
    }

    public function edit_bing_api_key(Request $request){

        $this->validate($request,[
            'api_key' => 'required',
        ]);

        $apikey = BingMapApiKey::where('id',$request->id)->first();
        $apikey->api_key = $request->api_key;
        $apikey->save();

        return redirect('admin/webconfig');
    }

    public function delete_bing_api_key(Request $request){
        $apikey = BingMapApiKey::where('id',$request->id)->first();

        if($apikey!=null){
            //if the key to be deleted is in use
            if($apikey->in_use == 1) {
                $next = BingMapApiKey::where('fetch_order', $apikey->fetch_order + 1)->first();
                if($next!=null){
                    $next = BingMapApiKey::where('fetch_order', 1)->first();
                }
                if($next!=null) {
                    $next->in_use = 1;
                    $next->save();
                }
            }

            $apikey->delete();

            $keys = BingMapApiKey::orderBy('id','ASC')->get();
            $fetch_order = 1;
            foreach ($keys as $key){
                $key->fetch_order = $fetch_order;
                $key->save();
                $fetch_order++;
            }
        }

        return redirect('admin/webconfig');
    }
}

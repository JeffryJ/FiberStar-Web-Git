<?php

namespace App\Http\Controllers;

use App\ContactUsCC;
use App\Mail\ContactUsEmail;
use App\Rules\ValidPhoneNumber;
use App\Webconfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class ContactMessageController extends Controller
{
    public function create_contact_us_email(Request $request){

        $validation = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>['required',new ValidPhoneNumber()],
            'address'=>'required',
            'message'=>'required'
        ]);
//        $this->validate($request,[
//            'name'=>'required',
//            'email'=>'required|email',
//            'phone'=>['required',new ValidPhoneNumber()],
//            'address'=>'required',
//            'message'=>'required'
//        ]);

        if($validation->fails()){
            return response()->json(

                    $validation->messages()

                ,200);
        }

        $webconfig = Webconfig::orderBy('created_at','DESC')->first();
        $ccs = [];
        $mails = ContactUsCC::get();
        foreach ($mails as $mail){
            array_push($ccs,$mail->email);
        }

        Mail::to($webconfig->contact_email)->cc($ccs)->send(new ContactUsEmail($request));

        return response()->json(
            array(
                'success'=>'Message Sent!'
            )
            ,200);

    }
}

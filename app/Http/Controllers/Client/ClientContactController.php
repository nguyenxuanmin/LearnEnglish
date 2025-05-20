<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ClientContactController extends Controller
{
    public function contact(Request $request){
        $name = trim($request->nameContact);
        $email = trim($request->emailContact);
        $content = trim($request->contentContact);
        if($name == ''){
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập họ và tên.'
            ]);
        }
        if($email == ''){
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập email.'
            ]);
        }else{
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'success' => false,
                    'message' => $email. ' không phải là email hợp lệ.'
                ]);
            }
            $contactExist = Contact::where('email',$email)->first();
            if(isset($contactExist)){
                return response()->json([
                    'success' => false,
                    'message' => 'Email đã gửi liên hệ.'
                ]);
            }
        }
        if($content == ''){
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập nội dung.'
            ]);
        }

        $details = [
            'name' => $name
        ];

        Mail::to($email)->send(new ContactMail($details));

        $contact = new Contact();
        $contact->name = $name;
        $contact->email = $email;
        $contact->content = $content;
        $contact->save();

        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }
}

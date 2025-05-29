<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ClientContactController extends Controller
{
    public function contact(Request $request){
        $name = trim($request->nameContact);
        $email = trim($request->emailContact);
        $content = trim($request->contentContact);
        if(empty($name)){
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập họ và tên.'
            ]);
        }
        if(empty($email)){
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
        if(empty($content)){
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập nội dung.'
            ]);
        }

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

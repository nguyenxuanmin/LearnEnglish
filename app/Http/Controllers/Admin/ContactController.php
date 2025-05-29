<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(){
        $contacts = Contact::OrderBy('created_at','desc')->paginate(20);
        return view('admin.contact.list',[
            'contacts' => $contacts,
            'infoSearch' => ''
        ]);
    }

    public function view($id){
        $contact = Contact::find($id);
        if ($contact->isRead != 1) {
            $contact->isRead = 1;
            $contact->save();
        }
        $titlePage = $contact->name;
        return view('admin.contact.main',[
            'titlePage' => $titlePage,
            'contact' => $contact
        ]);
    }

    public function delete(Request $request){
        $contact = Contact::find($request->id);
        $contact->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function search(Request $request){
        $infoSearch = $request->search;
        $contacts = Contact::where('name','LIKE','%'.$infoSearch.'%')->OrderBy('created_at','desc')->paginate(20);
        return view('admin.contact.list',[
            'infoSearch' => $infoSearch,
            'contacts' => $contacts
        ]);
    }
}

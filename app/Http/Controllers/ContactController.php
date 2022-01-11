<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Validator;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderByDesc('created_at')->paginate(5);
        return $contacts;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'phone'     => 'required|digits:10',
            'email'     => 'email|unique:contacts',
            'location'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        $contact = new Contact();

        $contact->phone = $request->phone;
        $contact->location = $request->location;
        if($request->email){
            $contact->email = $request->email;
        }
        
        $contact->save();

        if ($contact->exists) {
            return response()->json(['success' => 'Contact created successfuly'], 200);
        } else {
            return response()->json(['error' => 'Error'], 422);
        }
    }

    public function show($id)
    {
        $contact = Contact::where('id',$id)->first();
        if($contact != null){
            return $contact;
        }else{
            return response()->json(['error' => 'Contact not found'], 404);
        }
    }

    public function edit(Contact $contact)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'phone'     => 'required|digits:10',
            'email'     => 'email|unique:contacts',
            'location'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        $contact = Contact::where('id',$id)->first();

        if($contact != null){
            $contact->phone = $request->phone;
            $contact->location = $request->location;
            if($request->email){
                $contact->email = $request->email;
            }
            $contact->save();
    
            if ($contact->exists) {
                return response()->json(['success' => 'Contact updated successfuly'], 200);
            } else {
                return response()->json(['error' => 'Error'], 422);
            }
        }else{
            return response()->json(['Error' => 'Contact with the given id not found']);
        }

    }
    
    public function destroy($id)
    {
        $contact = Contact::where('id',$id)->first();
        if($contact){
            $contact->delete();
            return response()->json(['success' => 'Contact deleted successfuly'], 200);
        }else{
            return response()->json(['error' => 'Delete unsuccessful, Contact not found'], 404);
        }
    }
}

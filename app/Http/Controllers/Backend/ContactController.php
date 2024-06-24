<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() {
        $contacts = Contact::all();
        return view('backend.pages.contact.index',compact('contacts'));
    }

    public function edit($id) {
        $contact = Contact::where('id',$id)->firstOrFail();
        return view('backend.pages.contact.edit',compact('contact'));
    }

    public function update(Request $request , $id) {
        $update = $request->status;
        Contact::where('id',$id)->update(['status' => $update]);
        return redirect()->route('panel.contact.index');
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete($id);


        return redirect()->route('panel.contact.index');
    }
}

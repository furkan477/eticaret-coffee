<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Str;
use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function iletisimkaydet(ContactFormRequest $request)
    {

        $newdata =[
            'name'=> Str::title($request->name),
            'email'=> $request->email,
            'subject'=> $request->subject,
            'message'=> $request->message,
            'ip'=> request()->ip(),
        ];

       $sonkaydedilen =  Contact::create($newdata);


       Mail::to('demo@gmail.com')->send(new ContactMail($newdata));

       return redirect()->route('anasayfa');;
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('anasayfa');
    }
}

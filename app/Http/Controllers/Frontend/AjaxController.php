<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function iletisimkaydet(ContactFormRequest $request)
    {

        $data = $request->all();
        $data['ip'] = $request->ip();

        $kayit = Contact::create($data);

        return back()->with(['message'=>'Başarıyla Gönderildi']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('anasayfa');
    }
}

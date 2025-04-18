<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('welcome');  
    }

    public function sendForm(ContactFormRequest $request)
    {
        $data = $request->validated();

        Mail::to('nexuscontrol.ph@gmail.com')->send(new ContactFormMail($data));

        // Redirect back with a success message
        return redirect()->route('contact')->with('success', 'Your message has been sent!');
    }
}
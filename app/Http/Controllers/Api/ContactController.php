<?php

namespace App\Http\Controllers\Api;

use App\ContactUS;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $contact = new ContactUS();
        $contact->name = $request->get('name');
        $contact->email = $request->get('email');
        $contact->subject = $request->get('subject');
        $contact->message = $request->get('message');

        Mail::send(new ContactMail($contact, env('ADMIN_EMAIL')));
        return response()->json(['message', 'Thanks for contacting!']);
    }
}

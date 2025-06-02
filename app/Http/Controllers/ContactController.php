<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request)
{
    $contact = Contact::create($request->validated());

   
    Mail::to('ammaralalisa@gmail.com')->send(new ContactMessageMail($contact));

    return new ContactResource($contact);
}
}

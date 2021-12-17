<?php


namespace App\Http\Controllers;


use App\Mail\ContactMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $name = $request->input("name");
        $email = $request->input("email");
        $subject = $request->input("subject");
        $message = $request->input("message");

        Mail::to("noreply@onlineshop.com")->send(new ContactMailer($name, $email, $subject, $message));

        return response()->json(["message" => "Message sent successfully and we will reply to you as soon as possible"]);
    }
}
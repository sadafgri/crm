<?php

namespace App\Http\Controllers;



use App\Mail\MailNotify;
use Illuminate\Http\Request;
use Mail;


class MailController extends Controller
{
    public function index()
    {
        $data=[
            'subject'=>'crm email',
            'body'=>'Hello this is my email'
            ];
        try{
            Mail::to(auth()->user()->email)->send(new MailNotify($data));
            return response()->json(['plz check your mail box']);

        }catch(Exception $th){
            return response()->json($th->getMessage());
        }
    }
}

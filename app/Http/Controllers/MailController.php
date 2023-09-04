<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail ;


class MailController extends Controller
{
    public static function sendMail($destination,$body)
    {

        $data = [
            'subject' => 'Khasa Aljo3',
            'body' => $body
        ];
        try{
      Mail::to($destination)->send(new OtpMail($data));

        return response()->json(['great check your email box']);
        }catch(Exception $err){

            return response()->json(['sorry something went wrong']);
        }
    }
}

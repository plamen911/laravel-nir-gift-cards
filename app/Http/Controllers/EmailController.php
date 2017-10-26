<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function send(Request $request)
    {
        $data = [];

        Mail::send('emails.to-admin', $data, function ($message) {
            $message->from('axereliat@gmail.com', 'Mario M.')
                ->to('plamen326@gmail.com')
                ->subject('test mail from nir-gift-cards');
        });

        if (Mail::failures()) {
            $errorMessage = 'There was one or more failures. They were: <br>';
            foreach(Mail::failures() as $emailAddress) {
                $errorMessage .= '- ' . $emailAddress . '<br>';
            }
            return response()->json(['error' => $errorMessage]);
        }

/*        $title = 'Hi';
        $content = 'Content of the email...';

        Mail::send('emails.send', ['title' => $title, 'content' => $content], function ($message) {
            $message->from('axereliat@gmail.com', 'Mario M.');
            $message->to('plamen326@gmail.com');
        });*/

        return response()->json(['message' => 'Request completed']);
    }
}

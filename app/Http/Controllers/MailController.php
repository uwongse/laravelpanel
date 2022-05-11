<?php
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Mail\DemoEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
 
class MailController extends Controller
{
    public function send(Request $request)
    {
        $contenido = [
            'name'=>$request->name,
            'email'=>$request->email,
            'mensaje'=>$request->mensaje,
        ];
 
        Mail::to("trabajocmcmola@gmail.com")->send(new DemoEmail($contenido));
    }
}
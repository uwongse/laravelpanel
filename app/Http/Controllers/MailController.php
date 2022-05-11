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
        $contenido = $request->validate([
            'name'=>'required',
            'email'=>'required',
            'mensaje'=>'required',
        ]);
 
        Mail::to("trabajocmcmola@gmail.com")->send(new DemoEmail($contenido));
    }
}
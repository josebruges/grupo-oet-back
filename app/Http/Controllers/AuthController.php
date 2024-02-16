<?php

namespace App\Http\Controllers;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodigoGeneradoMail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
    	$user = User::where('correo', $request->input('correo'))->first();
    	if(!$user)	return response()->json(["status"=>400, "data"=>"El usuario no existe"],404);


		$code = $user->code;
		Mail::to($user->correo)->send(new CodigoGeneradoMail($code));

		return response()->json(['message'=>'codigo enviado']);

    	

    }

}
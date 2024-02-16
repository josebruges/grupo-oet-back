<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequet;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodigoGeneradoMail;
use Firebase\JWT\JWT;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth')->except(['index','validateCode','store','update']);
    }


    public function index()
    {
        return UserResource::collection(User::orderByDesc('created_at')->get());
    }


    public function store(UserStoreRequest $request)
    {
        $randomCode = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['code'] = $randomCode;
        $user = User::create($data);
        if ($user) {
            Mail::to($user->correo)->send(new CodigoGeneradoMail($randomCode));
            return response()->json([
                'data' => $user
            ]);
        }

        return response()->json([
            'message' => 'Error al crear usuario',
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return UserResource::make($user);
    }

    public function update(UserUpdateRequet $request, $id)
    {
        $user = User::findOrFail($id)->update($request->all());

        if ($user) {
            return response()->json([
                'message' => 'Usuario Modificado con exito'
            ]);
        }

        return response()->json([
            'message' => 'Error al Editar usuario',
        ]);
    }

    protected function jwt(User $user)
    {
    	$datos = [
    	'correo' 		        =>	$user->correo,
		'status'				=>	$user->status,
		'nombres'				=>	$user->nombres,
		'apellidos'				=>	$user->apellidos,
		'cedula'				=>	$user->cedula,
		'telefono'				=>	$user->telefono,
		'address'				=>	$user->address,
		'cedula_front'			=>	$user->cedula_front,
		'cedula_later'			=>	$user->cedula_later,
		'id'			        =>  $user->id,
    	'iat' 			        => time(),
        'exp' 			        => time() + 60*60
    	];

    	return JWT::encode($datos, env('JWT_SECRET'), 'HS256');
    }

    public function validateCode(Request $request)
    {
        $user = User::where('correo', $request->input('correo'))->first();
    	if(!$user)	return response()->json(["status"=>400, "data"=>"El usuario no existe"],404);

        if($request->input('code') == $user->code)
    	{
            User::where('correo', $request->input('correo'))->update(['status' => 'true']);

    		return response()->json(["status"=>200, "verificado"=> $this->jwt($user)]);
    	}

        return response()->json(["status"=> 400, "data" => "Codigo incorrecto"],400);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthApiController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais inválidas!'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'Não foi possível criar o token!'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function refreshToken(Request $request)
    {
        if (!$token = $request->get('token')) {
            return response()->json(['error'=>'Token não enviado!'],401);
        }
        try {
            // Atualiza o token expirado para um novo
            $token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $e) {
            return response()->json(['error'=>'Token inserido não é valido!'],401);
        }
        // Retorna o novo token gerado
        return response()->json(compact('token'));
    }
}

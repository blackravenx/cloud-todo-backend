<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $user->exists ?
            $response = ['message' => 'Вы успешно зарегестрировались!', 'status' => 201] :
            $response = ['message' => 'Не удалось выполнить регистрацию', 'status' => 500];
        return response($response['message'], $response['status']);
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $auth = Auth::user();
            return response([
                'token' => $auth->createToken('token')->plainTextToken,
                'auth' => true,
                'id' => $auth->id,
                'name' => $auth->name,
                'message' => 'Успешный вход!'
            ], 200);
        } else {
            return response(['message' => 'Неправильные данные!'], 203);
        }
    }
}

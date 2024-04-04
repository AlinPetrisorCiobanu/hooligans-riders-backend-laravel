<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function healthcheck(){
        return response()->json(
            [
                'success' => true,
                'message' => 'OK',
                'data' => 'todo perfecto'
            ],
            Response::HTTP_OK
        );
    }

    public function register(Request $request)
    {
        try {
            // validar
            $validator = $this->validateRegisterDataUser($request);
            
            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'User not registered',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // recoger info
            $name = $request->input('name');
            $last_name = $request->input('last_name');
            $date = $request->input('date');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $nickname = $request->input('nickname');
            $password = $request->input('password');

            // tratar info
            $encryptedPassword = bcrypt($password);

            // guardarla
            $newUser = User::create(
                [
                    'name' => $name,
                    'last_name' => $last_name,
                    'date' => $date,
                    'phone' => $phone,
                    'email' => $email,
                    'nickname' => $nickname,
                    'password' => $encryptedPassword,
                    'role' => 'user',
                ]
            );

            // devolver respuesta
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User registered successfully',
                    'data' => $newUser
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'User cant be registered',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function validateRegisterDataUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'last_name' => 'required|min:3|max:100',
            'date' => 'required|min:3|max:20',
            'phone' => 'required|unique:users|min:8|max:15',
            'email' => 'required|unique:users|email|min:6|max:250',
            'nickname' => 'required|unique:users|min:3|max:100',
            'password' => 'required|min:6|max:12',
        ]);
        return $validator;
    }

    public function login(Request $request)
    {
        try {
            // validar
            $validator = Validator::make($request->all(), [
                'email' => 'required_without:nickname|email',
                'nickname' => 'required_without:email|min:3|max:250',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'User cant be logged',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            // recoger info
            $email = $request->input('email');
            $nickname = $request->input('nickname');
            $password = $request->input('password');

            if($nickname) $user = User::query()->where('nickname', $nickname)->first();
            if($email) $user = User::query()->where('email', $email)->first();


            if (!$user) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Email or password invalid',
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // Comprobar password
            $passwordIsValid = Hash::check($password, $user->password);

            if (!$passwordIsValid) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Email or password invalid',
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // Verificar si el usuario está activo
            if (!$user->is_active) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'User is not active. Please contact support.',
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // generar token
            $token = $user->createToken('apiToken')->plainTextToken;

            // devolver respuesta
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User loged successfully',
                    'data' => $user,
                    'token' => $token
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'User cant be logged',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function logout(Request $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();
            if ($user) {
                $request->user()->currentAccessToken()->delete();
            }
            return response()->json([
                'success' => true,
                'message' => $user,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error logging out',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}

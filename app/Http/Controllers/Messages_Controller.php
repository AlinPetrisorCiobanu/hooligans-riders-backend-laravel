<?php

namespace App\Http\Controllers;

use App\Models\messages;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class Messages_Controller extends Controller
{
    public function list_messages(Request $request)
    {
        try {
            if (auth()->user()->is_active === 0) {
                throw error('usuario borrado');
            }
            if (auth()->user()->role === "rider") {
                throw error('no tienes permiso');
            }
            $page_count = $request->query('count', 6);
            $messages = messages::where('is_active', 1)->paginate($page_count);
            return response()->json(
                [
                    'succes' => true,
                    'message' => 'mensajes',
                    'data' => $messages
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'succes' => false,
                    'message' => 'Error marking user as inactive',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function new_message(Request $request)
    {
        try {
            if (auth()->user()->is_active === 0) {
                throw error('usuario borrado');
            }

            // validar
            $validator = $this->validate_event($request);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'missed data',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            //recoger info
            $name = $request->input('name');
            $last_name = $request->input('last_name');
            $data = $request->input('data');
            $message = $request->input('message');

            $new_message = messages::create(
                [
                    'id_user' => auth()->user()->id,
                    'name' => $name,
                    'last_name' => $last_name,
                    'data' => $data,
                    'message' => $message,
                ]
            );

            return response()->json(
                [
                    'succes' => true,
                    'message' => 'mensaje',
                    'data' => $new_message
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'succes' => false,
                    'message' => 'Error marking user as inactive',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function validate_event(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'last_name' => 'required|min:3|max:50',
            'data' => 'required|min:1|max:150',
            'message' => 'required|min:1|max:800',
        ]);
        return $validator;
    }

    public function delete_message( $id_message)
    {
        try {
            if (auth()->user()->is_active === 0) {
                throw error('usuario borrado');
            }
            if (auth()->user()->role === "rider") {
                throw error('no tienes permiso');
            }
            $message = messages::findOrFail($id_message);
            $message->is_active = 0;
            $message->save();

            // devolver respuesta
            return response()->json(
                [
                    'succes' => true,
                    'message' => 'mensajes',
                    'data' => $message
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'succes' => false,
                    'message' => 'Error marking user as inactive',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MainController extends Controller
{
    
    public function addUser(Request $request){

        try{

            $data = $request->validate([
                'name' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6'
            ], [
                'name.required' => 'Preencha o campo nome',
                'lastname.required' => 'Preencha o campo sobrenome',
                'email.required' => 'Preencha o campo email',
                'email.email' => 'Formato de email inválido',
                'email.unique' => 'Email já está em uso',
                'password.required' => 'Preencha o campo senha',
                'password.min' => 'Senha deve conter no mínimo 6 caracters' 
            ]);

            $user = User::create([
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);

            if($user){

                return response()->json([
                    'status' => 'success',
                    'msg' => 'Cadastro realizado com sucesso'
                ], 201);

            } else{

                return response()->json([
                    'status' => 'error',
                    'msg' => 'Erro ao tentar cadastrar usuário'
                ]);
            }

        } catch(ValidationException $e){

            return response()->json([
                'status' => 'error',
                'msg' => 'Erro de validação',
                'messages' => $e->errors()
            ], 422);

        }

    }

    public function getUsers(){

        $users = User::all();

        return response()->json([
            'msg' => 'success',
            'users' => $users
        ]);
    }

    public function getUser($id){

        $user = User::find((int) $id);

        if(!$user){

            return response()->json([
                'status' => 'error',
                'msg' => 'Nenhum usuário foi encontrado'
            ]);

        }

        return response()->json([
            'status' => 'success',
            'user' => $user 
        ]);
    }

    public function updateUser(Request $request, $id){

        $user = User::find($id);

        if(!$user){

            return response()->json([
                'status' => 'error',
                'msg' => 'Nenhum usuário foi encontrado'
            ]);
        }

        try{

            $data = $request->validate([
                'name' => 'sometimes|string',
                'lastname' => 'sometimes|string',
                'email' => [
                    'sometimes',
                    'email',
                    Rule::unique('users')->ignore($id)
                ],
                'password' => 'sometimes|min:6',
            ], [
                'email.email' => 'Formato de email inválido',
                'email.unique' => 'Email já está em uso',
                'password.min' => 'Senha deve conter no mínimo 6 caracters' 
            ]);

            $user->update([
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);

            if($user){

                return response()->json([
                    'status' => 'success',
                    'msg' => 'Atualizado com sucesso'
                ], 201);

            } else{

                return response()->json([
                    'status' => 'error',
                    'msg' => 'Erro ao tentar atualizar usuário'
                ]);
            }

        } catch(ValidationException $e){

            return response()->json([
                'status' => 'error',
                'msg' => 'Erro de validação',
                'messages' => $e->errors()
            ], 422);

        }
        
    }

    public function deleteUser($id){

        $user = User::find($id);

        if(!$user){

            return response()->json([
                'status' => 'error',
                'msg' => 'Nenhum usuário foi encontrado'
            ]);
        }

        if($user->delete()){

            return response()->json([
                'status' => 'success',
                'msg' => 'Usuário removido com sucesso'
            ]);

        } else{

            return response()->json([
                'status' => 'error',
                'msg' => 'Erro ao tentar remover usuário'
            ]);
        }

    }
}

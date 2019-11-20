<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    
    public function getAll(){

        $json = [
            'message' => '',
            '_redirectURI' => null,
            'data' => User::all()
        ];

        return response()->json($json, 200);
        
    }

    public function find(User $user){

        $json = [
            'message' => '',
            '_redirectURI' => null,
            'data' => $user
        ];

        return response()->json($json, 200);

    }

    public function create(Request $req){

        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;

        try {
            
            $user->save();

            $json = [
                'message' => 'Usuário criado com sucesso',
                '_originalMessage' => null,
                '_redirectURI' => null,
                'data' => $user
            ];

            $status = 201;

        } catch (\Exception $e) {
            
            if($e->errorInfo[1] == 1062){
                $json = [
                    'message' => 'E-Mail já está cadastrado em outro usuário',
                    '_originalMessage' => $e->getMessage(),
                    '_redirectURI' => null,
                    'data' => null
                ];
            }else{
                $json = [
                    'message' => 'Erro ao criar Usuário',
                    '_originalMessage' => $e->getMessage(),
                    '_redirectURI' => null,
                    'data' => null
                ];
            }


            $status = 409;

        }

        return response()->json($json, $status);

    }

    public function update(User $user, Request $req){
        
        $user->name = $req->name;
        $user->email = $req->email;
        
        try {
            
            $user->save();

            $json = [
                'message' => 'Usuário atualizado com sucesso',
                '_originalMessage' => null,
                '_redirectURI' => null,
                'data' => $user
            ];

            $status = 202;

        } catch (\Exception $e) {

            if($e->errorInfo[1] == 1062){
                $json = [
                    'message' => 'E-Mail já está cadastrado em outro usuário',
                    '_originalMessage' => $e->getMessage(),
                    '_redirectURI' => null,
                    'data' => null
                ];
            }else{
                $json = [
                    'message' => 'Erro ao atualizar o usuário',
                    '_originalMessage' => $e->getMessage(),
                    '_redirectURI' => null,
                    'data' => null
                ];
            }

            $status = 409;

        }

        return response()->json($json, $status);

    }

    public function delete(User $user){

        try {

            $user->delete();

            $json = [
                'message' => 'Usuário Excluído com Sucesso',
                '_originalMessage' => null,
                '_redirectURI' => null,
                'data' => $user
            ];

            $status = 203;

        } catch (\Exception $e) {

            if($e->errorInfo[1] == 1451){
                $json = [
                    'message' => 'Impossível excluir um usuário com tarefas relacionadas a ele.',
                    '_originalMessage' => $e->getMessage(),
                    '_redirectURI' => null,
                    'data' => $user
                ];
            }else{
                $json = [
                    'message' => 'Erro ao excluir usuário.',
                    '_originalMessage' => $e->getMessage(),
                    '_redirectURI' => null,
                    'data' => $user
                ];
            }

            $status = 409;

        }

        return response()->json($json, $status);

    }

}

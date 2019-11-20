<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Task;

class TaskController extends Controller
{
   
    public function getAll(){

        $json = [
            'message' => '',
            '_redirectURI' => null,
            'data' => Task::with('user')->get()
        ];

        return response()->json($json, 200);
        
    }

    public function find(Task $task){

        $json = [
            'message' => '',
            '_redirectURI' => null,
            'data' => $task
        ];

        return response()->json($json, 200);

    }

    public function create(Request $req){

        $task = new Task();
        $task->description = $req->description;
        $task->deadline = $req->deadline;
        $task->user_id = $req->user_id;

        try {
            
            $task->save();

            $json = [
                'message' => 'Tarefa inserida com sucesso',
                '_originalMessage' => null,
                '_redirectURI' => null,
                'data' => $task
            ];

            $status = 201;

        } catch (\Exception $e) {
            
            $json = [
                'message' => 'Erro ao inserir a tarefa',
                '_originalMessage' => $e->getMessage(),
                '_redirectURI' => null,
                'data' => null
            ];

            $status = 422;

        }

        return response()->json($json, $status);

    }

    public function update(Task $task, Request $req){

        $task->description = $req->description;
        $task->deadline = $req->deadline;
        $task->user_id = $req->user_id;

        try {
            
            $task->save();

            $json = [
                'message' => 'Tarefa atualizada com sucesso',
                '_originalMessage' => null,
                '_redirectURI' => null,
                'data' => $task
            ];

            $status = 202;

        } catch (\Exception $e) {

            $json = [
                'message' => 'Erro ao atualizar a tarefa',
                '_originalMessage' => $e->getMessage(),
                '_redirectURI' => null,
                'data' => null
            ];

            $status = 422;

        }

        return response()->json($json, $status);

    }

    public function delete(Task $task){
        
        try {
            $task->delete();

            $json = [
                'message' => 'Tarefa excluída com sucesso',
                '_originalMessage' => null,
                '_redirectURI' => null,
                'data' => $task
            ];

            $status = 203;

        } catch (\Exception $e) {
            
            $json = [
                'message' => 'Erro ao excluir a tarefa',
                '_originalMessage' => $e->getMessage(),
                '_redirectURI' => null,
                'data' => $task
            ];

            $status = 203;

        }

        return response()->json($json, $status);

    }

}

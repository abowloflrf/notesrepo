<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

class TodosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get()
    {
        $todos = auth()->user()->todo;
        if ($todos->all_todos == null) {
            $createTodos = new Todo;
            $createTodos->email = auth()->user()->email;
            $createTodos->all_todos = json_encode([]);
            $createTodos->save();
            return response()->json([]);
        }
        return response()->json(json_decode($todos['all_todos']));
    }

    public function update(Request $request)
    {
        $oldTodos = auth()->user()->todo;
        $newTodos = $request->get('todos');
        $oldTodos->all_todos = $newTodos;
        if ($oldTodos->save()) {
            return response()->json(array(
                'status' => 'SUCCESS',
                'msg' => 'Successfully saved todos.'
            ));
        } else {
            return response()->json(array(
                'status' => 'ERROR',
                'msg' => 'Failed to save todos.'
            ));
        }
    }
}

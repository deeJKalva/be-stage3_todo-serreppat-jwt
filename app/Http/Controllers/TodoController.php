<?php

namespace App\Http\Controllers;

use App\Services\TodoService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TodoController extends Controller
{
    protected $user;
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $this->todoService = $todoService;
    }

    public function index()
    {
        return $this->todoService->getTodosByUserId($this->user->id)->toArray();
    }

    public function show($title)
    {
        $todo = $this->todoService->find($this->user->id, $title);

        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo '.$title.' can not be found in User '.$this->user->id.'`s Todo List.',
            ]);
        }

        return $todo;
    }

    public function store(Request $request)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $this->user->id
        ];

        $todo = $this->todoService->store($data);

        if ($todo) {
            return response()->json([
                'success' => true,
                'message' => 'Todo added successfully.',
                'todo' => $todo
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo can not be added.',
            ], 500);
        }
    }

    public function update(Request $request, $title)
    {
        $todo = $this->todoService->find($this->user->id, $title);

        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo '.$title.' can not be found in User '.$this->user->id.'`s Todo List.',
            ], 400);
        }

        $updated = $this->todoService->update($todo, $request->all());

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Todo updated successfully.',
                'updated' => [
                    'todo' => $todo->title,
                    'description' => $request->description
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo could not be updated.',
            ], 500);
        }
    }

    public function destroy($title)
    {
        $todo = $this->todoService->find($this->user->id, $title);

        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo '.$title.' can not be found in User '.$this->user->id.'`s Todo List.',
            ], 400);
        }

        if ($todo->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Todo '.$title.' in User '.$this->user->id.'`s Todo List deleted successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo '.$title.' in User '.$this->user->id.'`s Todo List could not be deleted.',
            ], 500);
        }
    }
}
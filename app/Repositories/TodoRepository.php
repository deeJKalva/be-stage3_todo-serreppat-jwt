<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository
{
    protected $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function getAllByUserId($user_id) : Object
    {
        return $this->todo->where('user_id', $user_id)->get(['title', 'description', 'user_id']);
    }

    public function store($data)
    {
        $newData = new $this->todo;
        $newData->title = $data['title'];
        $newData->description = $data['description'];
        $newData->user_id = $data['user_id'];
        $newData->save();
        return $newData->fresh();
    }

    public function find($user_id, $title)
    {
        return $this->todo->where('user_id', $user_id)->where('title', $title)->first();
    }

    public function updated($updated)
    {
        return $updated->save();
    }
}
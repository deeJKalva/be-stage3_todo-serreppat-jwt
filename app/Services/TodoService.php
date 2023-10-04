<?php

namespace App\Services;

use App\Repositories\TodoRepository;

class TodoService
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getTodosByUserId($user_id)
    {
        return $this->todoRepository->getAllByUserId($user_id);
    }

    public function store($data)
    {
        return $this->todoRepository->store($data);
    }

    public function find($user_id, $title)
    {
        return $this->todoRepository->find($user_id, $title);
    }

    public function update($todo, $update)
    {
        $updated = $todo->fill($update);
        return $this->todoRepository->updated($updated);
    }
}
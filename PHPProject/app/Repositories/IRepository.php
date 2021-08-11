<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IRepository 
{
    public function getByID(int $id) : Model;
    public function create(array $data) : Model;
    public function update(int $id, array $data) : Model;
    public function deleteById(int $id): void;
}
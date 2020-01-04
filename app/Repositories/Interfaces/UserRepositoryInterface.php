<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function get($userId);

    public function all();

    public function delete($userId);

    public function update($userId, array $data);

    public function create(array $data);
}
<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Репозиторий для работы с пользователем
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Получение пользователя
     *
     * @param $userId
     */
    public function get($userId)
    {

    }

    public function all()
    {

    }

    public function delete($userId)
    {

    }

    public function update($userId, array $data)
    {

    }

    /**
     * Создание пользователя
     *
     * @param  array $data
     * @throws \Exception
     */
    public function create(array $data)
    {
        $name      = $data['name'];
        $surname   = $data['surname'];
        $password  = Hash::make($data['password']);
        $email     = $data['email'];
        $year      = $data['year'];
        $city      = $data['city'];
        $gender    = $data['gender'];
        $interests = $data['interests'];

        $ok = DB::insert(
            'INSERT INTO users(name, surname, gender, interests, email, password, city, year)'
            . 'VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [$name, $surname, $gender, $interests, $email, $password, $city, $year]
        );

        if (!$ok) {
            throw new \Exception('Cannot add user to the database');
        }
    }
}
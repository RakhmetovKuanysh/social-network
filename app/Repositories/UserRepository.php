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
     * {@inheritdoc}
     *
     * @param  int $userId
     * @return \App\User
     */
    public function get(int $userId)
    {

    }

    /**
     * {@inheritdoc}
     *
     * @param  int $userId
     * @return void
     */
    public function delete(int $userId)
    {

    }

    /**
     * {@inheritdoc}
     *
     * @param  int $userId
     * @param  array $data
     * @return void
     */
    public function update(int $userId, array $data)
    {

    }

    /**
     * {@inheritdoc}
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
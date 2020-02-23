<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\DB;

/**
 * Репозиторий для работы с пользователем
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param  string     $email
     * @param  string     $password
     * @return \App\User
     * @throws \Exception
     */
    public function getByCredentials(string $email, string $password)
    {
        $result = DB::selectOne(
            'SELECT * FROM users WHERE email=? AND password=?',
            [$email, md5($password)]
        );

        if (empty($result)) {
            return null;
        }

        return new User((array) $result);
    }

    /**
     * {@inheritdoc}
     *
     * @param  int       $id
     * @return \App\User
     */
    public function getById(int $id)
    {
        $result = DB::selectOne('SELECT * FROM users WHERE id=?', [$id]);

        if (empty($result)) {
            return null;
        }

        return new User((array) $result);
    }

    /**
     * {@inheritdoc}
     *
     * @param  string    $email
     * @return \App\User
     */
    public function getByEmail(string $email)
    {
        $result = DB::selectOne('SELECT * FROM users WHERE email=?', [$email]);

        if (empty($result)) {
            return null;
        }

        return new User((array) $result);
    }

    /**
     * {@inheritdoc}
     *
     * @param  string    $email
     * @return \App\User[]
     */
    public function getAllLikeEmail(string $email, int $limit = 20)
    {
        $result = DB::table('users')
            ->where('email', 'like', '%' . $email . '%')
            ->take($limit)
            ->get();

        if (empty($result)) {
            return [];
        }

        return $result->all();
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
        $password  = md5($data['password']);
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
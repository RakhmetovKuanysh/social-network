<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    /**
     * Получение пользователя по id
     *
     * @param  int       $userId
     * @return \App\User
     */
    public function getById(int $userId);

    /**
     * Получение пользователя по email
     *
     * @param  string    $email
     * @return \App\User
     */
    public function getByEmail(string $email);

    /**
     * Получение пользователей с похожим email
     *
     * @param  string      $email
     * @return \App\User[]
     */
    public function getAllLikeEmail(string $email);

    /**
     * Получение пользователя по логину и паролю
     *
     * @param  string    $email
     * @param  string    $password
     * @return \App\User
     */
    public function getByCredentials(string $email, string $password);

    /**
     * Удаление пользователя
     *
     * @param  int $userId
     * @return void
     */
    public function delete(int $userId);

    /**
     * Обновление пользователя
     *
     * @param  int $userId
     * @param  array $data
     * @return void
     */
    public function update(int $userId, array $data);

    /**
     * Создание пользователя
     *
     * @param  array $data
     * @return void
     */
    public function create(array $data);
}
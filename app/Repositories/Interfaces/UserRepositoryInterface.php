<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    /**
     * Получение пользователя
     *
     * @param  int $userId
     * @return \App\User
     */
    public function get(int $userId);

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
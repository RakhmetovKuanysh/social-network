<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface
{
    /**
     * Добавление поста
     *
     * @param  array $data
     * @return void
     */
    public function create(array $data);

    /**
     * Получение постов
     *
     * @param  int   $userId
     * @return array
     */
    public function getPosts(int $userId);
}
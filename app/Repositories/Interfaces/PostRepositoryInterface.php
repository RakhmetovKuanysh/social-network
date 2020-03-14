<?php

namespace App\Repositories\Interfaces;

use App\User;

interface PostRepositoryInterface
{
    /**
     * Добавление поста
     *
     * @param  array $data
     * @param  User  $user
     * @return void
     */
    public function create(array $data, User $user);

    /**
     * Получение поста по id
     *
     * @param  int       $postId
     * @return \App\Post
     */
    public function getById(int $postId);

    /**
     * Получение постов
     *
     * @param  int   $userId
     * @return array
     */
    public function getPosts(int $userId);
}
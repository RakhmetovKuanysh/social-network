<?php

namespace App\Repositories\Interfaces;

interface SubscriberRepositoryInterface
{
    /**
     * Добавление подписки
     *
     * @param  int  $followerId
     * @param  int  $subscriberId
     * @return void
     */
    public function create(int $followerId, int $subscriberId);

    /**
     * Удаление подписки
     *
     * @param  int  $followerId
     * @param  int  $subscriberId
     * @return void
     */
    public function delete(int $followerId, int $subscriberId);
}
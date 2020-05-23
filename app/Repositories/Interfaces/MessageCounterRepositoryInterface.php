<?php

namespace App\Repositories\Interfaces;

interface MessageCounterRepositoryInterface
{
    /**
     * Получение количества непрочитанных сообщений
     *
     * @param  int $userId
     * @return int
     */
    public function getNbUnreadMessages(int $userId);
}
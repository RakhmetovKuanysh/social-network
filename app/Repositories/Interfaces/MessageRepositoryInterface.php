<?php

namespace App\Repositories\Interfaces;

interface MessageRepositoryInterface
{
    /**
     * Отправка сообщения
     *
     * @param  int    $senderId
     * @param  int    $receiverId
     * @param  string $text
     * @return void
     */
    public function create(int $senderId, int $receiverId, string $text);

    /**
     * Все сообщения с пользователем
     *
     * @param  int $firstUserId
     * @param  int $secondUserId
     * @return \App\Message[]
     */
    public function getMessages(int $firstUserId, int $secondUserId);

    /**
     * Получение чатов
     *
     * @param  int $userId
     * @return array
     */
    public function getThreads(int $userId);
}
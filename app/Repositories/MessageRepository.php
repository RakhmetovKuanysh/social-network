<?php

namespace App\Repositories;

use App\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use Illuminate\Support\Facades\DB;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param  int    $senderId
     * @param  int    $receiverId
     * @param  string $text
     * @return void
     * @throws \Exception
     */
    public function create(int $senderId, int $receiverId, string $text)
    {
        $ok = DB::insert(
            'INSERT INTO messages(sender_id, receiver_id, text, created_at) VALUES (?, ?, ?, ?)',
            [$senderId, $receiverId, $text, now()]
        );

        if (!$ok) {
            throw new \Exception('Cannot add message to the database');
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param  int $firstUserId
     * @param  int $secondUserId
     * @return \App\Message[]
     */
    public function getMessages(int $firstUserId, int $secondUserId)
    {
        $result = DB::select(
            'SELECT * FROM messages WHERE (receiver_id=? AND sender_id=?) '
            . 'OR (receiver_id=? AND sender_id=?) ORDER BY created_at',
            [$firstUserId, $secondUserId, $secondUserId, $firstUserId]
        );

        if (empty($result)) {
            return null;
        }

        $messages = [];

        foreach ($result as $message) {
            $messages[] = new Message((array) $message);
        }

        return $messages;
    }
}
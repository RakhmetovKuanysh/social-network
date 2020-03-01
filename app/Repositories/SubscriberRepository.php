<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SubscriberRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SubscriberRepository implements SubscriberRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param  int        $followerId
     * @param  int        $subscriberId
     * @throws \Exception
     */
    public function create(int $followerId, int $subscriberId)
    {
        $ok = DB::insert(
            'INSERT INTO subscribers(follower_id, subscriber_id) VALUES (?, ?)',
            [$followerId, $subscriberId]
        );

        if (!$ok) {
            throw new \Exception('Cannot add subscription to the database');
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param  int        $followerId
     * @param  int        $subscriberId
     * @throws \Exception
     */
    public function delete(int $followerId, int $subscriberId)
    {
        $ok = DB::insert(
            'DELETE FROM subscribers WHERE follower_id=? AND subscriber_id=?',
            [$followerId, $subscriberId]
        );

        if (!$ok) {
            throw new \Exception('Cannot delete subscription from the database');
        }
    }
}
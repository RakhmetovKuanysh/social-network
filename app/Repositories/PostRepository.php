<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Репозиторий для работы с постами
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param  array $data
     * @throws \Exception
     */
    public function create(array $data)
    {
        $text   = $data['text'];
        $userId = $data['userId'];

        $ok = DB::insert(
            'INSERT INTO posts(text, user_id, created_at) VALUES (?, ?, ?)',
            [$text, $userId, now()]
        );

        if (!$ok) {
            throw new \Exception('Cannot add post to the database');
        }
    }
}
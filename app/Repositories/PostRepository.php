<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

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

    /**
     * {@inheritdoc}
     *
     * @param  int   $userId
     * @return array
     */
    public function getPosts(int $userId)
    {
        $posts = Redis::get('posts:' . $userId);

        if ($posts !== null) {
            return $posts;
        }

        $user           = Session::get('user');
        $followingUsers = $user->following;
        $result         = [];

        foreach ($followingUsers as $following) {
            $result = array_merge($result, $this->getFollowingPosts($following->follower_id));
        }

        usort($result, function ($a, $b) {
            return $a->created_at < $b->created_at;
        });

        return $result;
    }

    /**
     * Посты пользователей
     *
     * @param  int $userId
     * @param  int $limit
     * @return array
     */
    protected function getFollowingPosts(int $userId, int $limit = 20)
    {
        $result = DB::table('posts')
            ->where('user_id', $userId)
            ->take($limit)
            ->get();

        if (empty($result)) {
            return [];
        }

        return $result->all();
    }
}

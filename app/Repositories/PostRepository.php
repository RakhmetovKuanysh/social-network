<?php

namespace App\Repositories;

use App\User;
use App\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

/**
 * Репозиторий для работы с постами
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param  array     $data
     * @param  User      $user
     * @return \App\Post
     */
    public function create(array $data, User $user): Post
    {
        $post = new Post();
        $post->setText($data['text']);
        $post->setUserId($data['userId']);
        $post->setCreatedAt(now());

        $postId = DB::table('posts')->insertGetId(
            [
                'text'       => $post->getText(),
                'user_id'    => $post->getUserId(),
                'created_at' => $post->getCreatedAt(),
            ]
        );

        $post->setId($postId);

//        $data = ['postId' => $postId, 'userId' => $post->getUserId()];

//        Amqp::publish('posts', json_encode($data), ['queue' => 'posts']);

        return $post;
    }

    /**
     * {@inheritdoc}
     *
     * @param  int       $id
     * @return \App\Post
     */
    public function getById(int $id)
    {
        $result = DB::selectOne('SELECT * FROM posts WHERE id=?', [$id]);

        if (empty($result)) {
            return null;
        }

        return new Post((array) $result);
    }

    /**
     * {@inheritdoc}
     *
     * @param  int   $userId
     * @return array
     */
    public function getPosts(int $userId)
    {
//        $posts = Redis::get('posts:' . $userId);
//
//        if ($posts !== null) {
//            return json_decode($posts);
//        }

        $user           = Auth::user();
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
    protected function getFollowingPosts(int $userId)
    {
        $result = DB::table('posts')
            ->where('user_id', $userId)
            ->get();

        if (empty($result)) {
            return [];
        }

        return $result->all();
    }
}

<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ListenRabbit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:custom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(UserRepositoryInterface $userRepository, PostRepositoryInterface $postRepository)
    {
        try {
            Amqp::consume('posts', function ($message, $resolver) use ($userRepository, $postRepository) {
                $data = json_decode($message->body);
                $post = $postRepository->getById($data->postId);
                $user = $userRepository->getById($data->userId);

                if (null === $user || null === $post) {
                    $resolver->reject($message);
                }

                $subscribers = $user->subscribers;

                foreach ($subscribers as $subscriber) {
                    $key          = 'posts:' . $subscriber->subscriber_id;
                    $cacheElement = Redis::get($key);
                    $posts        = [];

                    if (null !== $cacheElement) {
                        $posts = json_decode($cacheElement);
                    }

                    $posts = array_merge([$post], $posts);
                    Redis::set($key, json_encode($posts));
                }

                $resolver->acknowledge($message);
            });
        }catch(\PhpAmqpLib\Exception\AMQPTimeoutException $ex){
            echo "Connection timed out. Restarting.";
        }
    }
}

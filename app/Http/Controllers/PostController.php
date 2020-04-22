<?php

namespace App\Http\Controllers;

use App\Events\PostUpdatedEvent;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Контроллер для публикаций
 */
class PostController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user;

    /**
     * @var PostRepositoryInterface
     */
    protected $post;

    /**
     * Конструктор
     *
     * @param  UserRepositoryInterface $user
     * @param  PostRepositoryInterface $post
     * @return void
     */
    public function __construct(UserRepositoryInterface $user, PostRepositoryInterface $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Публикация постов
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     *         |\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function publish(Request $request)
    {
        if (Auth::user() === null) {
            return redirect('home');
        }

        $text   = $request->get('text');
        $userId = $request->get('userId');

        if (!empty($text)) {
            $user = $this->user->getById($userId);

            try {
                $post        = $this->post->create($request->all(), $user);
                $subscribers = $user->subscribers;

                foreach ($subscribers as $subscriber) {
                    broadcast(new PostUpdatedEvent($post->toArray(), $subscriber->subscriber_id));
                }
            } catch (\Exception $e) {}
        }

        return redirect()->route('profile', ['id' => $userId]);
    }

    /**
     * Получение постов
     */
    public function getPosts()
    {
        if (Auth::user() === null) {
            abort(403);
        }

        $userId = Auth::user()->id;

        return $this->post->getPosts($userId);
    }
}

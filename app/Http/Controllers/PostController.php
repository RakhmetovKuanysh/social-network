<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        if (!Session::has('user')) {
            return redirect('home');
        }

        $text   = $request->get('text');
        $userId = $request->get('userId');

        if (!empty($text)) {
            $user = $this->user->getById($userId);

            try {
                $this->post->create($request->all(), $user);
            } catch (\Exception $e) {}
        }

        return redirect()->route('profile', ['id' => $userId]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Главная страница
 */
class HomeController extends Controller
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
     * Главная страница
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Session::has('user')) {
            return redirect('login');
        }

        $user  = Session::get('user');
        $posts = $this->post->getPosts($user->id);

        return view('home', ['posts' => $posts]);
    }

    /**
     * Страница поиска
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $email = $request->get('email');
        $users = $this->user->getAllLikeEmail($email);

        return view('search', ['users' => $users]);
    }
}

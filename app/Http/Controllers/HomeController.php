<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\MessageCounterRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @var MessageCounterRepositoryInterface
     */
    protected $messageCounter;

    /**
     * Конструктор
     *
     * @param  UserRepositoryInterface           $user
     * @param  PostRepositoryInterface           $post
     * @param  MessageCounterRepositoryInterface $messageCounter
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $user,
        PostRepositoryInterface $post,
        MessageCounterRepositoryInterface $messageCounter
    ) {
        $this->user = $user;
        $this->post = $post;
        $this->messageCounter = $messageCounter;
    }

    /**
     * Главная страница
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user() === null) {
            return redirect('login');
        }

        $nbCntUnread = $this->messageCounter->getNbUnreadMessages(Auth::id());

        return view('home', ['nbCntUnread' => $nbCntUnread]);
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
        $nbCntUnread = $this->messageCounter->getNbUnreadMessages(Auth::id());

        return view('search', ['users' => $users, 'nbCntUnread' => $nbCntUnread]);
    }
}

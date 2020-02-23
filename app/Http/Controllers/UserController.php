<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Контроллер действий пользователя
 */
class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user;

    /**
     * Конструктор
     *
     * @param  UserRepositoryInterface $user
     * @return void
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Страница регистрации
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     *         |\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function profile(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('home');
        }

        $id   = $request->get('id');
        $user = $this->user->getById($id);

        if (null === $user) {
            abort(404);
        }

        $sessionUser  = Session::get('user');
        $subscribers  = $user->subscribers;
        $isSubscribed = false;

        foreach ($subscribers as $subscriber) {
            if ($subscriber->subscriber_id === $sessionUser->id) {
                $isSubscribed = true;
            }
        }

        return view('profile', ['user' => $user, 'isSubscribed' => $isSubscribed]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     *         |\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function profile()
    {
        if (!Session::has('user')) {
            return redirect('home');
        }

        return view('profile', ['user' => Session::get('user')]);
    }
}
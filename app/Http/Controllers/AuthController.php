<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Контроллер авторизации и аутентификации
 */
class AuthController extends Controller
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
    public function register()
    {
        if (Session::has('user')) {
            return redirect('home');
        }

        return view('register');
    }

    /**
     * Страница авторизации
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     *         |\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function login()
    {
        if (Session::has('user')) {
            return redirect('home');
        }

        return view('login');
    }

    /**
     * Аутентификация
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticate(Request $request)
    {
        $email     = $request->get('email');
        $password  = $request->get('password');
        $validator = Validator::make([$email, $password], []);
        $user      = $this->user->getByCredentials($email, $password);

        if ($user instanceof User) {
            Session::put('user', $user);

            return redirect('profile');
        }

        $validator->errors()->add('password', 'Invalid credentials');

        return redirect('login')->withErrors($validator);
    }

    /**
     * Регистрация пользователя
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post(Request $request)
    {
        $data = $request->all();

        try {
            $this->user->create($data);
        } catch (\Exception $e) {
            return redirect('register')->with('message', 'Error while creating user');
        }

        return redirect('login')->with('message', 'Registration successfully completed');
    }

    /**
     * Выход
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Session::flush();

        return Redirect('login');
    }
}
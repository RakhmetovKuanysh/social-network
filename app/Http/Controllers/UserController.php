<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\SubscriberRepositoryInterface;
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
     * @var SubscriberRepositoryInterface
     */
    protected $subscriber;

    /**
     * Конструктор
     *
     * @param  UserRepositoryInterface $user
     * @return void
     */
    public function __construct(UserRepositoryInterface $user, SubscriberRepositoryInterface $subscriber)
    {
        $this->user       = $user;
        $this->subscriber = $subscriber;
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

        return view('profile', [
            'user'         => $user,
            'posts'        => $user->posts,
            'isSubscribed' => $isSubscribed,
        ]);
    }

    /**
     * Подписка на пользователя
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     *         |\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function subscribe(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('home');
        }

        $subscriberId = Session::get('user')->id;
        $followerId   = $request->get('userId');

        try {
            $this->subscriber->create($followerId, $subscriberId);
        } catch (\Exception $e) {}

        return redirect()->route('profile', ['id' => $followerId]);
    }

    /**
     * Отписка от пользователя
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     *         |\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function unsubscribe(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('home');
        }

        $subscriberId = Session::get('user')->id;
        $followerId   = $request->get('userId');

        try {
            $this->subscriber->delete($followerId, $subscriberId);
        } catch (\Exception $e) {}

        return redirect()->route('profile', ['id' => $followerId]);
    }
}

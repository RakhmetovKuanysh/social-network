<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\MessageCounterRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\SubscriberRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @var MessageCounterRepositoryInterface
     */
    protected $messageCounter;

    /**
     * Конструктор
     *
     * @param  UserRepositoryInterface       $user
     * @param  SubscriberRepositoryInterface $subscriber
     * @param  MessageCounterRepositoryInterface $messageCounter
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $user,
        SubscriberRepositoryInterface $subscriber,
        MessageCounterRepositoryInterface $messageCounter
    ) {
        $this->user       = $user;
        $this->subscriber = $subscriber;
        $this->messageCounter = $messageCounter;
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
        if (Auth::user() === null) {
            return redirect('home');
        }

        $id   = $request->get('id');
        $user = $this->user->getById($id);

        if (null === $user) {
            abort(404);
        }

        $sessionUser  = Auth::user();
        $subscribers  = $user->subscribers;
        $isSubscribed = false;

        foreach ($subscribers as $subscriber) {
            if ($subscriber->subscriber_id === $sessionUser->id) {
                $isSubscribed = true;
            }
        }

        $nbCntUnread = $this->messageCounter->getNbUnreadMessages(Auth::id());

        return view('profile', [
            'user'         => $user,
            'posts'        => $user->posts,
            'isSubscribed' => $isSubscribed,
            'nbCntUnread'  => $nbCntUnread
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
        if (Auth::user() === null) {
            return redirect('home');
        }

        $subscriberId = Auth::user()->id;
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
        if (Auth::user() === null) {
            return redirect('home');
        }

        $subscriberId = Auth::user()->id;
        $followerId   = $request->get('userId');

        try {
            $this->subscriber->delete($followerId, $subscriberId);
        } catch (\Exception $e) {}

        return redirect()->route('profile', ['id' => $followerId]);
    }
}

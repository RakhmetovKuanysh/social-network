<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Контроллер для сообщений
 */
class MessageController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user;

    /**
     * @var MessageRepositoryInterface
     */
    protected $message;

    /**
     * Конструктор
     *
     * @param  UserRepositoryInterface $user
     * @param  MessageRepositoryInterface $message
     * @return void
     */
    public function __construct(UserRepositoryInterface $user, MessageRepositoryInterface $message)
    {
        $this->user    = $user;
        $this->message = $message;
    }

    /**
     * Страница сообщений
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     *         |\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('home');
        }

        $userId      = (int) $request->get('userId');
        $user        = $this->user->getById($userId);
        $sessionUser = Session::get('user');

        if ($userId === $sessionUser->id || !($user instanceof User)) {
            abort(404);
        }

        $messages = $this->message->getMessages($userId, $sessionUser->id);

        return view('messages', ['user' => $user, 'messages' => $messages]);
    }

    /**
     * Отправка сообщения
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendMessage(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('home');
        }

        $userId      = (int) $request->get('userId');
        $user        = $this->user->getById($userId);
        $sessionUser = Session::get('user');

        if ($userId === $sessionUser->id || !($user instanceof User)) {
            abort(404);
        }

        $text = $request->get('text');

        try {
            $this->message->create($sessionUser->id, $userId, $text);
        } catch (\Exception $e) {
            return redirect('messages?userId=' . $userId)->with('message', 'Error while sending message');
        }

        return redirect('messages?userId=' . $userId);
    }
}

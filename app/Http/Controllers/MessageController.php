<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Repositories\Interfaces\MessageCounterRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @var MessageCounterRepositoryInterface
     */
    protected $messageCounter;

    /**
     * Конструктор
     *
     * @param  UserRepositoryInterface $user
     * @param  MessageRepositoryInterface $message
     * @param  MessageCounterRepositoryInterface $messageCounter
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $user,
        MessageRepositoryInterface $message,
        MessageCounterRepositoryInterface $messageCounter
    ) {
        $this->user    = $user;
        $this->message = $message;
        $this->messageCounter = $messageCounter;
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
        if (Auth::user() === null) {
            return redirect('home');
        }

        $userId      = (int) $request->get('userId');
        $user        = $this->user->getById($userId);
        $sessionUser = Auth::user();

        if ($userId === $sessionUser->id) {
            abort(404);
        }

        $nbCntUnread = $this->messageCounter->getNbUnreadMessages(Auth::id());

        if (!$user instanceof User) {
            $threads = $this->message->getThreads($sessionUser->id);

            return view('threads', ['threads' => $threads, 'nbCntUnread' => $nbCntUnread]);
        }

        $messages = $this->message->getMessages($userId, $sessionUser->id);

        return view('messages', ['user' => $user, 'messages' => $messages, 'nbCntUnread' => $nbCntUnread]);
    }

    /**
     * Отправка сообщения
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendMessage(Request $request)
    {
        if (Auth::user() === null) {
            return redirect('home');
        }

        $userId      = (int) $request->get('userId');
        $user        = $this->user->getById($userId);
        $sessionUser = Auth::user();

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

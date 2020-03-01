<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Контроллер для публикаций
 */
class PostController extends Controller
{
    /**
     * @var PostRepositoryInterface
     */
    protected $post;

    /**
     * Конструктор
     *
     * @param  PostRepositoryInterface $post
     * @return void
     */
    public function __construct(PostRepositoryInterface $post)
    {
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
            try {
                $this->post->create($request->all());
            } catch (\Exception $e) {}
        }

        return redirect()->route('profile', ['id' => $userId]);
    }
}

<?php

namespace App\Http\Controllers;

/**
 * Главная страница
 */
class HomeController extends Controller
{
    /**
     * Конструктор
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Главная страница
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}

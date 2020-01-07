<?php

namespace App\Http\Controllers;

/**
 * Главная страница
 */
class HomeController extends Controller
{
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

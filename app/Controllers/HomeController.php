<?php

class HomeController
{
    public function index(): void
    {
        render('dashboard', ['title' => 'Bookstore Dashboard']);
    }
}

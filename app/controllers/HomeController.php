<?php

class HomeController extends Controller
{
    public function index()
    {
        $data['judul'] = 'Beranda - ' . APP_NAME;
        $this->view('public/home', $data);
    }
}
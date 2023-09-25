<?php

class Home extends Controller
{
    public function index()
    {
        $data['judul'] = 'Home';
        $data['style'] = "/public/css/home.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('home/index', $data);
        $this->view('footer/index', $data);
    }
}

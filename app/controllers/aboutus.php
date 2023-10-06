<?php

class Aboutus extends Controller
{
    public function index()
    {
        $data['judul'] = 'Home';
        $data['style'] = "/public/css/aboutus.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('aboutus/index', $data);
    }
}

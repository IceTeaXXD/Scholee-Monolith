<?php

class Page404 extends Controller
{
    public function index()
    {
        $data['judul'] = '404 Page Not Found';
        $data['style'] = "/public/css/verify.css";
        $this->view('header/index', $data);
        $this->view('page404/index', $data);
    }
}

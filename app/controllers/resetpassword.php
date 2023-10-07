<?php

class Resetpassword extends Controller
{
    public function index()
    {
        $data['judul'] = 'Login Page';
        $data['style'] = "/public/css/login.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('resetpassword/index', $data);
    }
}

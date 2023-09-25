<?php

class Register extends Controller
{
    public function index()
    {
        $data['judul'] = 'Login Page';
        $data['style'] = "/public/css/login.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('register/index', $data);
    }

    public function error() {
        $data['judul'] = 'Login Page';
        $data['style'] = "/public/css/login.css";
        $data['error'] = "Registrasi Gagal";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('register/index', $data);
    }
}

<?php

class Login extends Controller
{
    public function index()
    {
        $data['judul'] = 'Login Page';
        $data['style'] = "/public/css/login.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('login/index', $data);
    }

    public function error() {
        $data['judul'] = 'Login Page';
        $data['style'] = "/public/css/login.css";
        $data['error'] = "Incorrect username or password.";
        // $data['email'] = $_SESSION['failemail'];
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('login/index', $data);
    }
}

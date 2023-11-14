<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'config/config.php';
require_once './api/polling/universitysync.php';
class Register extends Controller
{
    public function index()
    {
        $data['judul'] = 'Login Page';
        $data['style'] = "/public/css/register.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('register/index', $data);
    }
}

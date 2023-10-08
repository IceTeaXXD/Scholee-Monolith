<?php

class Resetpassword extends Controller
{
    public function index()
    {
        // check if there is any argument
        if (isset($_GET['token'])) {
            $data['judul'] = 'Reset Password';
            $data['style'] = "/public/css/login.css";
            $data['token'] = $_GET['token'];
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('resetpassword/index', $data);
        } else {
            $data['judul'] = 'Reset Password';
            $data['style'] = "/public/css/login.css";
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('resetpassword/index', $data);
        }
    }
}

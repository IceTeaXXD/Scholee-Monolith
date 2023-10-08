<?php

class Verify extends Controller
{
    public function index()
    {
        $data['judul'] = 'Verification';
        $data['style'] = "/public/css/verify.css";
        $data['token'] = $_GET['token'];
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $this->view('verify/index', $data);
    }
}

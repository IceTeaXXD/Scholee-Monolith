<?php

class AddBeasiswa extends Controller{
    public function index(){
        $data['judul'] = 'Add Beasiswa';
        $data['style'] = "/public/css/dashboard.css";
        $data['style'] = "/public/css/editprofile.css";
        if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('addbeasiswa/index', $data);
        } else {
            header('Location: /login');
        }
    }
}
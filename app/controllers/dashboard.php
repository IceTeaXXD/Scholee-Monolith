<?php

class Dashboard extends Controller
{
    public function index()
    {
        $data['judul'] = 'Dashboard';
        $data['style'] = "/public/css/dashboard.css";
        if (isset($_SESSION['username'])) {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('dashboard/index', $data);
        } else {
            header('Location: /login');
        }
    }
}
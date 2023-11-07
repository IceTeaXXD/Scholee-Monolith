<?php

class Assignments extends Controller{
    public function index(){
        $data['judul'] = 'Assignment';
        $data['style'] = "/public/css/dashboard.css";
        $data['style'] = "/public/css/userlist.css";
        $data['user_id'] = $_SESSION['user_id'];
        if (isset($_SESSION['username'])) {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('assignments/index', $data);
        } else {
            header('Location: /login');
        }
    }

    public function submit(){
        $data['judul'] = 'Submit';
        $data['style'] = "/public/css/addDocument.css";
        $data['user_id'] = $_SESSION['user_id'];
        if (isset($_SESSION['username'])) {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('assignments/submit', $data);
        } else {
            header('Location: /login');
        }
    }
}

?>
<?php

require_once 'app/models/registration.php';
require_once 'app/models/soap.php';
require_once 'app/core/Database.php';

class Registration extends Controller {
    public function index() {
        $data['judul'] = 'Registration';
        $data['style'] = "/public/css/dashboard.css";
        $data['style'] = "/public/css/scholarships.css";
        $data['user_id'] = $_SESSION['user_id'];
        if (isset($_SESSION['username'])) {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('registration/index', $data);
        } else {
            header('Location: /login');
        }
    }
}
?>
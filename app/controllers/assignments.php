<?php
require_once ("app/models/SOAP.php");
class Assignments extends Controller{
    public function index(){
        $client = new SOAP("ScholarshipAcceptance?wsdl");
        $param = Array("user_id_student" => $_SESSION['user_id']);
        $response = $client->doRequest("getAcceptanceStatus", $param);
        $data['assignments'] = json_encode($response->return);
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
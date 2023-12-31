<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Scholarship.php';
require_once 'app/models/SOAP.php';
require_once 'config/config.php';

class Scholarships extends Controller
{
    public function index()
    {
        if (isset($_SESSION['username'])) {
            $args = func_get_args();
            if (!isset($args[0])) {
                $data['judul'] = 'Scholarships';
                $data['style'] = "/public/css/scholarships.css";
                $this->view('header/index', $data);
                $this->view('navbar/index', $data);
                $this->view('scholarships/index', $data);
            } else { // View per scholarships
                $scholarshipModel = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
                $result = $scholarshipModel->getScholarship($args[0], $args[1]);

                /* Increment View Count */
                $soapClient = new SOAP("ScholarshipService?wsdl");
                $params = array("user_id_scholarship_php" => $args[0], "scholarship_id_php"=>$args[1]);
                $soapClient->doRequest("addScholarshipView", $params);

                foreach ($result as $row) {
                    $data['user_id'] = $row['user_id'];
                    $data['scholarship_id'] = $row['scholarship_id'];
                    $data['title'] = $row['title'];
                    $data['short_description'] = $row['short_description'];
                    $data['description'] = $row['description'];
                    $data['coverage'] = $row['coverage'];
                    $data['contact_name'] = $row['contact_name'];
                    $data['contact_email'] = $row['contact_email'];
                }
                $data['judul'] = $data['title'];
                $data['style'] = "/public/css/description.css";
                $this->view('header/index', $data);
                $this->view('navbar/index', $data);
                $this->view('scholarships/description', $data);
            }
        } else {
            header('Location: /login');
        }
    }

    public function add()
    {
        if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            $data['judul'] = 'Add Beasiswa';
            $data['style'] = "/public/css/dashboard.css";
            $data['style'] = "/public/css/addbeasiswa.css";
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('scholarships/add', $data);
        } else {
            header('Location: /login');
        }
    }

    public function edit()
    {
        if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            $data['judul'] = 'Edit Beasiswa';
            $data['style'] = "/public/css/dashboard.css";
            $data['style'] = "/public/css/addbeasiswa.css";

            $scholarshipModel = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
            $types = new ScholarshipType();

            $data['row'] = $scholarshipModel->getScholarship($_GET['user_id'], $_GET['scholarship_id']);
            $data['type'] = $types->getTypes($_GET['user_id'], $_GET['scholarship_id']);

            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('scholarships/edit', $data);
        } else {
            header('Location: /login');
        }
    }
}

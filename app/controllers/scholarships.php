<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Scholarship.php';
require_once 'config/config.php';

class Scholarships extends Controller {
    public function index() {
        $data['judul'] = 'Scholarships';
        $data['style'] = "/public/css/scholarships.css";
        $this->view('header/index', $data);
        $this->view('navbar/index', $data);
        $model = new Scholarship();
        $itemsPerPage = isset($_GET['itemsPerPage']) ? $_GET['itemsPerPage'] : 5;
        $totalScholarships = $model->countScholarships();
        if ($itemsPerPage === 'all') {
            $itemsPerPage = $totalScholarships;
        }
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; 
        $offset = ($currentPage - 1) * $itemsPerPage;
        $data['scholarships'] = $model->getAllScholarship($offset, $itemsPerPage);
        $data['totalScholarships'] = $totalScholarships;
        $data['itemsPerPage'] = $itemsPerPage;
        $data['currentPage'] = $currentPage;
        $this->view('scholarships/index', $data);
    }
    public function search() {
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
        $model = new Scholarship();
        $results = $model->searchScholarship($searchQuery, 0, 100);
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . $row['title'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td>' . $row['contact_name'] . '</td>';
            echo '<td>' . $row['contact_email'] . '</td>';
            echo "<td><a href='scholarships?item_id=" . $row['title'] . "'><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>Daftar</button></td>";
            echo '</tr>';
        }
    }
    
}
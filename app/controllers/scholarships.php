<?php
require_once 'app/core/App.php';
require_once 'app/core/Database.php';
require_once 'app/models/Scholarship.php';
require_once 'app/models/Scholarshiptype.php';
require_once 'config/config.php';

class Scholarships extends Controller
{
    public function index()
    {
        $args = func_get_args();
        if (!isset($args[0])) {
            $data['judul'] = 'Scholarships';
            $data['style'] = "/public/css/scholarships.css";
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $model = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
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
        } else {
            $scholarshipModel = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
            $result = $scholarshipModel->getScholarship($args[0], $args[1]);
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
    }

    public function search()
    {
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
        $model = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
        $results = $model->searchScholarship($searchQuery, 0, 100);
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . $row['title'] . '</td>';
            echo '<td>' . $row['short_description'] . '</td>';
            echo '<td>' . $row['coverage'] . '</td>';
            echo '<td>';
            $typeModel = new ScholarshipType;
            $types = $typeModel->getTypes($row['user_id'], $row['scholarship_id']);
            while ($r = mysqli_fetch_array($types)) {
                $typesArray[] = $r['type'];
            }
            echo implode(", ", $typesArray);
            unset($typesArray);
            echo '</td>';
            if ($_SESSION['role'] == 'student') {
                echo "<td><button type='button' onclick='bookmark(" . $row['user_id'] . "," . $row['scholarship_id'] . ")' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>Bookmark</button>";
                echo "<button type='button' onclick='' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>View More</button></td>";
            } else if ($_SESSION['role'] == 'admin') {
                echo ("<td>
                        <a href='scholarships/edit?user_id=" . $row['user_id'] . "&scholarship_id=" . $row['scholarship_id'] . "'>
                            <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>Edit</button>
                        </a>
                        <button type='button' onclick = 'deleteConfirmation(" . $row['user_id'] . "," . $row['scholarship_id'] . ")' class='btn btn-danger' data-toggle='modal' data-target='#exampleModalCenter'>Delete</button>
                    </td>");
            }
            echo '</tr>';
        }
    }

    public function add()
    {
        $data['judul'] = 'Add Beasiswa';
        $data['style'] = "/public/css/dashboard.css";
        $data['style'] = "/public/css/addbeasiswa.css";
        if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('addbeasiswa/index', $data);
        } else {
            header('Location: /login');
        }
    }

    public function edit()
    {
        $data['judul'] = 'Edit Beasiswa';
        $data['style'] = "/public/css/dashboard.css";
        $data['style'] = "/public/css/addbeasiswa.css";

        $scholarshipModel = new Scholarship($_SESSION['role'], $_SESSION['user_id']);
        $types = new ScholarshipType();

        $data['row'] = $scholarshipModel->getScholarship($_GET['user_id'], $_GET['scholarship_id']);
        $data['type'] = $types->getTypes($_GET['user_id'], $_GET['scholarship_id']);

        if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            $this->view('header/index', $data);
            $this->view('navbar/index', $data);
            $this->view('editbeasiswa/index', $data);
        } else {
            header('Location: /login');
        }
    }

    // view per scholarship
    public function description()
    {
    }
}

<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';
require_once '../../config/config.php';

try{
    $user = new User();

    $target = "../../public/image/profiles/";
    $filename = "";
    if(isset($_FILES['profilepic']))
        $filename = time() . '_' .$_FILES['profilepic']['name'];
    $target_file = $target. $filename;

    if($_POST['role'] == 'student'){
        require_once '../../app/models/Student.php';
        $student = new Student();
        $value = array(
            "user_id" => $_POST['user_id'],
            "name" => $_POST['name'],
            "level" => $_POST['level'],
            "street" => $_POST['street'],
            "email" => $_POST['email'],
            "major" => $_POST['major'],
            "city" => $_POST['city'],
            "zipcode" => $_POST['zipcode'],
            "university" => $_POST['university'],
            "image" => $filename
        );

        if($_FILES['profilepic']['name'] == ''){
            $value['image'] = '';
        }else{
            move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_file);
        }

        $user -> update($value);
        $student -> update($value);

    } else if ($_POST['role'] == 'admin'){
        require_once '../../app/models/administrator.php';
        $administrator = new Administrator();
        $value = array(
            "user_id" => $_POST['user_id'],
            "name" => $_POST['name'],
            "organization" => $_POST['organization'],
            "image" => $filename
        );

        if($_FILES['profilepic']['name'] == ''){
            $value['image'] = '';
        }else{
            move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_file);
        }

        $user -> update($value);
        $administrator -> update($value);

    } else if ($_POST['role'] == 'reviewer'){
        require_once '../../app/models/Reviewer.php';
        $model = new Reviewer();
        $value = array(
            "user_id" => $_POST['user_id'],
            "name" => $_POST['name'],
            "image" => $filename,
            "occupation" => $_POST['occupation']
        );

        if (isset($_FILES['profilepic']) && $_FILES['profilepic']['name'] != '') {
            move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_file);
        } else {
            $value['image'] = '';
        }

        $user->update($value);
        $model->update($value);
    }
    $response['status'] = 'success';
    $response['message'] = 'Profile updated successfully';
}catch(Exception $err){
    $response['status'] = 'error';
    $response['message'] = 'Failed to update profile: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
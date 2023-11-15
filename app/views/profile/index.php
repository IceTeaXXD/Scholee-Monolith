<?php
$row = mysqli_fetch_array($data['user']);

if($_SESSION['role'] == 'admin'){
    // Get the referral code from db
    $db = new Database();
    $query = "SELECT referral_code FROM administrator WHERE user_id = ?";
    $stmt = $db->setSTMT($query);
    mysqli_stmt_bind_param($stmt,"i", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $exec = mysqli_stmt_get_result($stmt);
    $res = mysqli_fetch_array($exec);
}
?>
<div class="profile-page">
    <div class="profile-info">
        <div class="grid-item-profile-1">
            <img id="profileDisplay" src="/public/image/profiles/<?php echo $row['image']; ?>" alt="Profile Image" class="profile-image-display" height="200px">
        </div>
        <div class="grid-item-profile-2">
            <h2 id="fullNameDisplay">Name: <?php echo $row['name']; ?></h2>
            <?php
            if ($_SESSION['role'] == 'student') {
            ?>
                <p class="profile-text">University: <?php echo $row['university']; ?></p>
                <p class="profile-text">Major: <?php echo $row['major']; ?></p>
                <p class="profile-text">Level: <?php echo $row['level']; ?></p>
            <?php } else if ($_SESSION['role'] == 'admin') { ?>
                <p class="profile-text">Organization: <?php echo $row['organization']; ?></p>
                <p class="profile-text">Referral Code: <?php echo $res['referral_code']; ?></p>
            <?php } else if ($_SESSION['role'] == 'reviewer') { ?>
                <p class="profile-text">Occupation: <?php echo $row['occupation']; ?></p>
            <?php } ?>
            <a href="/profile/edit" class="edit-btn">Edit Profile</a>
        </div>
    </div>
</div>
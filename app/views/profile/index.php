<?php
$row = mysqli_fetch_array($data['user']);
?>
<div class="profile-page">
    <div class="profile-info">
        <div class="grid-item-profile-1">
            <img id="profileDisplay" src="/public/image/profiles/<?php echo $row['image']; ?>" alt="Profile Image" class="profile-image-display" height="200px">
        </div>
        <div class="grid-item-profile">
            <h2 id="fullNameDisplay">Name: <?php echo $row['name']; ?></h2>
            <?php
            if ($_SESSION['role'] == 'student') {
            ?>
                <p class="profile-text">University: <?php echo $row['university']; ?></p>
                <p class="profile-text">Major: <?php echo $row['major']; ?></p>
                <p class="profile-text">Level: <?php echo $row['level']; ?></p>
            <?php } else if ($_SESSION['role'] == 'admin') { ?>
                <p class="profile-text">Organization: <?php echo $row['organization']; ?></p>
            <?php } else if ($_SESSION['role'] == 'reviewer') { ?>
                <p class="profile-text">Occupation: <?php echo $row['occupation']; ?></p>
            <?php } ?>
            <a href="/profile/edit" class="edit-btn">Edit Profile</a>
        </div>
    </div>
</div>
<?php
$row = mysqli_fetch_array($data['user']);
?>
<div class="profile-page">
    <div class="profile-info">
        <img id="profileDisplay" src="/public/image/profiles/<?php echo $row['image'];?>" alt="Profile Image" class="profile-image-display" height="200px">
        <h2 id="fullNameDisplay">Name: <?php echo $row['name'];?></h2>
        <p id="genderDisplay">University: <?php echo $row['university'];?></p>
        <p id="countryDisplay">Major: <?php echo $row['major'];?></p>
        <p id="dobDisplay">Level: <?php echo $row['level'];?></p>
        <a href="/profile/edit" class="edit-btn">Edit Profile</a>
    </div>
</div>
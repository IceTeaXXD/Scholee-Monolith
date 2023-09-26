<?php
$row = mysqli_fetch_array($data['user']);
?>
<div class="edit-profile">
    <form action="/api/profile/updateAdmin.php?user_id=<?php echo $data['user_id'];?>&email=<?php echo $data['email'];?>&role=<?php echo $data['role'];?>" method="post" class="profile-form" enctype="multipart/form-data">
        <div class="profile-info">

            <img id="profileDisplay" src="/public/image/profiles/<?php echo $row['image'];?>" alt="Profile Image" class="profile-image-display" height="200px">
            <div class="file-input-wrapper">
                <label class="file-input-label">
                    <input type="file" name = "profilepic" id="profileUpload" class="file-input">
                    <span class="file-input-text">Choose File</span>
                </label>
            </div>
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="name" value="<?php echo $row['name'];?>">
            <?php if($data['role'] == 'student'){ ?>
            <label for="gender">University</label>
            <input type="text" name="university" value = "<?php echo $row['university'];?>">
            <label for="dob">Major</label>
            <input type="text" name="major" value = "<?= $row['major'];?>">
            <label for="level">Level:</label>
            <select id="level" name="level">
                <option value="<?php echo $row['level'];?>"><?php echo $row['level'];?></option>
                <option value="Undergraduate">Undergraduate</option>
                <option value="Postgraduate">Postgraduate</option>
                <option value="Doctoral">Doctoral</option>
            </select>
            <label for="dob">Street</label>
            <input type="text" name="street" value = "<?php echo $row['street'];?>">
            <label for="dob">City</label>
            <input type="text" name="city" value = "<?php echo $row['city'];?>">
            <label for="dob">Zipcode</label>
            <input type="text" name="zipcode" value = "<?php echo $row['zipcode'];?>">
            <?php } else if ($data['role'] == 'admin') { ?>
            <label for="gender">Organization</label>
            <input type="text" name="organization" value = "<?php echo $row['organization'];?>">
            <?php } ?>

            <button type="submit" class="save-btn">Save Changes</button>
            <?php 
            if(strpos($_SERVER['REQUEST_URI'], "admin")==false){
            ?>
                <a href="/profile" class="cancel-btn">Cancel</a>
            <?php
            }else{
            ?>
                <a href="/admin/list" class="cancel-btn">Cancel</a>
            <?php
            }
            ?>
        </div>
    </form>
</div>

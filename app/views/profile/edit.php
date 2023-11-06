<?php
$row = mysqli_fetch_array($data['user']);
?>
<div class="edit-profile">
    <form action="javascript:;" onsubmit="return submitForm()" method="post" class="profile-form" enctype="multipart/form-data">
        <div class="profile-info">
            <div class="grid-items-1">
                <img id="profileDisplay" src="/public/image/profiles/<?php echo $row['image'];?>" alt="Profile Image" class="profile-image-display" height="200px">
                <div class="file-input-wrapper">
                    <label class="file-input-label">
                        <input type="file" name = "profilepic" id="profileUpload" class="file-input">
                        <span class="file-input-text">Choose File</span>
                    </label>
                </div>
            </div>
            <div class="grid-items-2">
                <label for="fullName">Full Name:</label>
                <input type="text" id="fullName" name="name" value="<?php echo $row['name'];?>">
                <?php if($_SESSION['role'] == 'student'){ ?>
                <label for="university">University</label>
                <input type="text" name="university" id="university" value = "<?php echo $row['university'];?>" disabled>
                <label for="major">Major</label>
                <input type="text" name="major" id="major" value = "<?= $row['major'];?>">
                <label for="level">Level:</label>
                <select id="level" name="level" id="level">
                    <option value="<?php echo $row['level'];?>"><?php echo $row['level'];?></option>
                    <option value="Undergraduate">Undergraduate</option>
                    <option value="Postgraduate">Postgraduate</option>
                    <option value="Doctoral">Doctoral</option>
                </select>
                <label for="street">Street</label>
                <input type="text" name="street" id="street" value = "<?php echo $row['street'];?>">
                <label for="city">City</label>
                <input type="text" name="city" id = "city"value = "<?php echo $row['city'];?>">
                <label for="zipcode">Zipcode</label>
                <input type="text" name="zipcode" id="zipcode" value = "<?php echo $row['zipcode'];?>">
                <?php } else if ($_SESSION['role'] == 'admin') { ?>
                <label for="organization">Organization:</label>
                <input type="text" name="organization" id="organization" value="<?php echo $row['organization']; ?>">
                <?php } else if ($_SESSION['role'] == 'reviewer'){?>
                <label for="occupation">Occupation</label>
                <input type="text" name="occupation" id="occupation"value = "<?php echo $row['occupation'];?>">
                <?php } ?>
    
                <button type="submit" class="save-btn">Save Changes</button>
                <a href="/profile" class="cancel-btn">Cancel</a>
            </div>
        </div>
    </form>
</div>
<script src="../../../public/js/updateProfile.js"></script>
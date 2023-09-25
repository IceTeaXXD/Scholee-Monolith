<div class="edit-profile">
    <form action="/api/scholarship/add.php" method="post" class="profile-form">
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
            <label for="gender">Organization</label>
            <input type="text" name="organization" value = "<?php echo $row['organization'];?>">

            <button type="submit" class="save-btn">Save Changes</button>
            <a href="/profile" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>

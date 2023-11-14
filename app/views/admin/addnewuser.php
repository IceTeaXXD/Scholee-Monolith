<div class = "add-beasiswa">
    <h1>Add User</h1>
    <div class="form">
        
        <form action="javascript:;" onsubmit="return submitForm()">
            <label for="scholarshipname">User Name</label>
            <input type="text" name="name" id = "scholarshipname" required />

            <label for="email">Email</label>
            <input type="email" name="email" id = "email" required />

            <label for="password">Password</label>
            <input type="password" name="password" id = "password" required />
            
            <label for="role">Role</label>
            <select name="role" id="role">
                <option value="student">Student</option>
                <option value="admin">Scholarship Admin</option>
                <option value="reviewer">Reviewer</option>
            </select>

            <label for="university">University</label>
            <select name="university" id="university">
                <?php 
                $db = new Database();
                $query = "SELECT university_id, name FROM university";
                $stmt = $db->setSTMT($query);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                while( $row = mysqli_fetch_assoc($result) ) {
                ?>
                <option value="<?php echo $row['university_id'];?>"><?php echo $row['name'];?></option>

                <?php } ?>
            </select>

            <button type = "submit" class="save-btn">Tambah User</button>
            <a href = "/dashboard" class="cancel-btn">Cancel</a>
        </form>

    </div>
</div>
<script src="../../../public/js/addnewuser.js"></script>
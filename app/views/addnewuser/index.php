<div class = "add-beasiswa">
    <h1>Add User</h1>
    <div class="form">
        
        <form method = "post" action = "/api/user/register.php">
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

            <button type = "submit" class="save-btn">Tambah User</button>
            <a href = "/dashboard" class="cancel-btn">Cancel</a>
        </form>

    </div>
</div>
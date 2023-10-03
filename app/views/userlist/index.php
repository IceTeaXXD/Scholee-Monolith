<div class="user-list">

    <div class="user-filter">
        <label for ="id">Role Selector</label>
        <select id="role" name="role">
            <option value="User">User</option>
            <option value="Administrator">Administrator</option>
            <option value="Reviewer">Reviewer</option>
        </select>

        <label for="search">Search User</label>
        <input type="text" id="search" name="search">
    </div>

    <div class="container">
        <?php
        while($row = mysqli_fetch_array($data['users'])){
        ?>
        <div class="box">
            <img class="profile" src="/public/image/profiles/<?php echo $row['image'];?>">
            <h3 class="name"><?php echo $row['name'];?></h3>
            <div class="attribute">Role: <?php echo $row['role'];?></div>
            <div class="attribute">Email: <?php echo $row['email'];?></div>
            <a href="/admin/update?user_id=<?php echo $row['user_id'];?>&email=<?php echo $row['email'];?>&role=<?php echo $row['role'];?>"> <button class="btn btn-primary">View More</button> </a>
            <button class="btn btn-danger" onclick="deleteConfirmation('<?php echo $row['name'];?>',<?php echo $row['user_id'];?>)">Delete</button></a>
        </div> 
        <?php
        }
        ?>
    </div>

</div>

<div id="modal" class="modal">
    <div class="modal-content">
        <h1>Delete Confirmation</h1>
        <p>Do you want to delete <span id="modal-name"></span>?</p>

        <button class="btn btn-danger" onclick="deleteUser()">Yes</button>
        <button class="btn btn-primary"onclick="closeModal()">No</button>
    </div>
</div>

<script src="/public/js/userlist.js"></script>
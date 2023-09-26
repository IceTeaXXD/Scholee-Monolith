<div class="user-list">

    <div class="user-filter">
        <label for ="id">Role Selector</label>
        <select id="role" name="role">
            <option value="User">User</option>
            <option value="Administrator">Administrator</option>
            <option value="Reviewer">Reviewer</option>
        </select>
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
            <a href=""> <button class="btn btn-primary">View More</button> </a>

            <a href=""><button class="btn btn-danger">Delete</button></a>
        </div> 
        <?php
        }
        ?>
    </div>

</div>
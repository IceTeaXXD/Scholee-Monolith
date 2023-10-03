<link rel="stylesheet" type="text/css" href="<?= $data['style']; ?>">
<div class="scholarship-body">
    <table class="container">
        <div class="search-form">
            <form method="get" id="search-form">
                <input type="text" name="search" id="search" placeholder="Search for items..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <thead>
            <tr>
                <th>
                    <h1>
                        <?php 
                            if($_SESSION['role']=='student'){
                        ?>
                        ID FILE
                        <?php 
                            }else{        
                        ?>
                        USER ID
                        <?php } 
                        ?>
                    </h1>
                </th>
                <th>
                    <h1>URL</h1>
                </th>
                <th>
                    <h1>Type</h1>
                </th>
                <th>
                    <h1>Review Status</h1>
                </th>
                <th>
                    <h1>Comment</h1>
                </th>
                <th>
                    <div class="pagination-form" id="pagination-form">
                        <form method="get">
                            <label for="itemsPerPage">Items Per Page:</label>
                            <select name="itemsPerPage" id="itemsPerPage" onchange="this.form.submit()">
                                <option value="5" <?php if ($data['itemsPerPage'] == 5) echo 'selected'; ?>>5</option>
                                <option value="10" <?php if ($data['itemsPerPage'] == 10) echo 'selected'; ?>>10</option>
                                <option value="15" <?php if ($data['itemsPerPage'] == 15) echo 'selected'; ?>>15</option>
                                <option value="all" <?php if ($data['itemsPerPage'] == 'all') echo 'selected'; ?>>All</option>
                            </select>
                        </form>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($data['row'])) {
                echo '<tr>';
                if ($_SESSION['role'] == 'student') {
                    echo '<td>' . $row['file_id'] . '</td>';
                }else if($_SESSION['role'] == 'reviewer'){
                    echo '<td>' . $row['user_id'] . '</td>';
                }
                if($row['type']!=='mp4'){
                    echo '<td><a href="/public/files/'.$row['link'].'" target="pdf">' . $row['link'] . '</a></td>';
                }else{
                    /* Modal For Video*/
                    echo "<td onclick='openVideoModal(\"/public/files/" . $row['link'] . "\")'>" . $row['link'] . "</td>";
                }
                echo '<td>' . $row['type'] . '</td>';
                echo '<td>' . $row['review_status'] . '</td>';
                if ($_SESSION['role'] == 'student') {
                    echo '<td>' . $row['comment'] . '</td>';
                }else if($_SESSION['role'] == 'reviewer'){
                    echo '<td><input type="text" value="'.$row['comment'].'" id="comment-'.$row['user_id'].'-'.$row['file_id'].'" required></td>';
                }
                if ($_SESSION['role'] == 'student') {
                    echo "<td><button type='button' onclick='submitDocument(".$_SESSION['user_id'].",".$row['file_id'].")' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>Daftarkan</button></td>";
                }else if ($_SESSION['role'] == 'reviewer'){
                    echo "<td><button type='button' onclick='commentDocument(".$row['user_id'].",".$row['file_id'].")' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>Comment</button></td>";
                }
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <div class="pagination-button" id="pagination-button">
        <?php
        if ($data['totalScholarships'] == 0) {
            echo "<tr>";
            echo "<td colspan='4'>There are no open submissions right now, please check back later! :D.</td>";
            echo "</tr>";
        } else {
            if ($data['itemsPerPage'] == $data['totalScholarships']) {
                echo "<a href='scholarships?page=1&itemsPerPage=all'>1</a>";
            } else {
                $totalPages = ceil($data['totalScholarships'] / $data['itemsPerPage']);
                for ($i = 1; $i <= $totalPages; $i++) {
                    $isActive = $i == $data['currentPage'] ? 'active' : '';
                    echo "<a href='scholarships?page=$i&itemsPerPage=" . $data['itemsPerPage'] . "' class='$isActive'>" . $i . "</a> ";
                }
            }
        }
        ?>
    </div>
</div>

<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Video Player</h1>
        <video id="videoPlayer" class="videoPlayer" controls>
            <source id="videoSource" src="" type="video/mp4">
        </video>
    </div>
</div>

<script src="../../../public/js/submitDocument.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchForm = document.getElementById("search-form");
        const searchInput = document.getElementById("search");
        const scholarshipBody = document.querySelector(".scholarship-body tbody");
        const paginationForm = document.getElementById("pagination-form");

        searchForm.addEventListener("submit", function (e) {
            e.preventDefault();
            performSearch();
        });

        searchInput.addEventListener("input", function () {
            performSearch();
        });

        function performSearch() {
            const searchQuery = searchInput.value;
            fetch(`/scholarships/search?search=${searchQuery}`)
                .then((response) => response.text())
                .then((data) => {
                    scholarshipBody.innerHTML = data;
                    paginationForm.style.display = "none";
                })
                .catch((error) => {
                    console.error("Error fetching data:", error);
                });
        }
    });
</script>

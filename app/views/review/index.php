<link rel="stylesheet" type="text/css" href="/public/css/search.css">
<div class="scholarship-body">
    <table class="container">
        <div class="search-form">
            <body>
                <form autocomplete="off">
                    <label for="search">Search</label>
                    <input id="search" type="search" pattern=".*\S.*" required>
                    <span class="caret"></span>
                </form>
            </body>
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
                    <h1>File</h1>
                </th>
                <th>
                    <h1>Type</h1>
                </th>
                <th>
                    <h1>Review Status</h1>
                </th>
                <th class="comment">
                    <h1>Comment</h1>
                </th>
                <th>
                    <div class="pagination-form" id="pagination-form">
                        <form method="get">
                            <label for="itemsPerPage">Items Per Page:</label>
                            <select name="itemsPerPage" id="itemsPerPage">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="all">All</option>
                            </select>
                        </form>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody id="content">
            <?php
            while ($row = mysqli_fetch_array($data['row'])) {
                echo '<tr>';
                if ($_SESSION['role'] == 'student') {
                    echo '<td>' . $row['file_id'] . '</td>';
                }else if($_SESSION['role'] == 'reviewer'){
                    echo '<td>' . $row['user_id'] . '</td>';
                }
                if($row['type']!=='mp4'){
                    echo '<td><a class="file" href="/public/files/'.$row['link'].'" target="pdf">' . $row['link'] . '</a></td>';
                }else{
                    /* Modal For Video*/
                    echo "<td style='cursor: pointer;' onclick='openVideoModal(\"/public/files/" . $row['link'] . "\")'>" . $row['link'] . "</td>";
                }
                echo '<td>' . $row['type'] . '</td>';
                echo '<td>' . $row['review_status'].'</td>';
                if ($_SESSION['role'] == 'student') {
                    if($row['review_status'] == 'reviewed'){
                        echo '<td class="comment">' . $row['comment'] . '<br> -- <br>'. $row['name'] .' <br><i>'. $row['occupation'].'</i></td>';
                    }else{
                        echo '<td class="comment"> </td>';
                    }
                }else if($_SESSION['role'] == 'reviewer'){
                    echo '<td class="comment"><input type="text" value="'.$row['comment'].'" id="comment-'.$row['user_id'].'-'.$row['file_id'].'" required></td>';
                }
                if ($_SESSION['role'] == 'student') {
                    echo "<td><button type='button' onclick='submitDocument(".$_SESSION['user_id'].",".$row['file_id'].")' data-toggle='modal' data-target='#exampleModalCenter'>Daftarkan</button></td>";
                }else if ($_SESSION['role'] == 'reviewer'){
                    echo "<td><button type='button' onclick='commentDocument(".$row['user_id'].",".$row['file_id'].")' data-toggle='modal' data-target='#exampleModalCenter'>Comment</button></td>";
                }
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <div class="pagination-button" id="pagination-button">
        <?php
        if ($data['totalScholarships'] == 0) {
            // echo "<tr>";
            // echo "<td colspan='4'>There are no open submissions right now, please check back later! :D.</td>";
            // echo "</tr>";
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

<div id="alert-modal" class="modal">
    <div class="modal-content">
        <h3 class="modal-title">You have already submitted this document!</h3>
        <button class="btn btn-primary" id="closeModalBTN" onclick="closeModalAlert()">Close</button>
    </div>
</div>

<script>
    var user_id = "<?php echo $_SESSION['user_id'];?>";
    var role = "<?php echo $_SESSION['role'];?>";  
</script>
<script src="../../../public/js/submitDocument.js"></script>
<script src="../../../public/js/searchReview.js"></script>
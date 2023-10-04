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
                    <h1>NAMA BEASISWA</h1>
                </th>
                <th>
                    <h1>DESKRIPSI</h1>
                </th>
                <th>
                    <h1>Coverage</h1>
                </th>
                <th>
                    <h1>Types</h1>
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
            while ($row = mysqli_fetch_array($data['scholarships'])) {
                echo '<tr>';
                echo '<td>' . $row['title'] . '</td>';
                echo '<td>' . $row['short_description'] . '</td>';
                echo '<td> $' . number_format($row['coverage'], 0, ',', '.') . '</td>';
                echo '<td>';
                $typeModel = new ScholarshipType;
                $types = $typeModel->getTypes($row['user_id'], $row['scholarship_id']);
                while($r = mysqli_fetch_array($types)){
                    $typesArray[] = $r['type'];
                }
                echo implode(", ", $typesArray);
                unset($typesArray);
                echo '</td>';
                if ($_SESSION['role'] == 'student') {
                    echo "<td><button type='button' onclick='bookmark(".$row['user_id'].",".$row['scholarship_id'].")' data-toggle='modal' data-target='#exampleModalCenter'>Bookmark</button>";
                    echo "<button type='button' onclick='redirectToScholarships(".$row['user_id'].",".$row['scholarship_id'].")' data-toggle='modal' data-target='#exampleModalCenter'>View More</button></td>";
                } else if ($_SESSION['role'] == 'admin') {
                    echo ("<td>
                            <a href='scholarships/edit?user_id=".$row['user_id'] ."&scholarship_id=".$row['scholarship_id']."'>
                                <button type='button' data-toggle='modal' data-target='#exampleModalCenter'>Edit</button>
                            </a>
                            <button type='button' onclick = 'deleteConfirmation(".$row['user_id'].",".$row['scholarship_id'].")' data-toggle='modal' data-target='#exampleModalCenter'>Delete</button>
                        </td>");
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

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3 class="title">Apakah Anda benar ingin melakukan penghapusan?</h3>
        <button class="btn btn-primary" onclick="confirmDelete()">Ya</button>
        <button class="btn btn-danger closebtn" onclick="cancelDelete()">Tidak</button>
    </div>
</div>

<div id="alert-modal" class="modal">
    <div class="modal-content">
        <h3 class="modal-title">
            This scholarship has been bookmarked!
        </h3>
        <button class="btn btn-primary" onclick="closeModal()">Ok</button>
    </div>
</div>

<script src="/public/js/deleteConfirm.js"></script>
<script src="/public/js/bookmark.js"></script>
<script src="/public/js/scholarships.js"></script>
<link rel="stylesheet" type="text/css" href=<?= $data['style']; ?>>
<div class="scholarship-body">
    <table class="container">
        <div class="search-form">
            <form method="get">
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
                    <h1>CP</h1>
                </th>
                <th>
                    <h1>EMAIL</h1>
                </th>
                <th>
                    <div class="pagination-form">
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
                echo '<td>' . $row['description'] . '</td>';
                echo '<td>' . $row['contact_name'] . '</td>';
                echo '<td>' . $row['contact_email'] . '</td>';
                if($_SESSION['role'] == 'student'){
                    echo "<td><a href='scholarships?item_id=" . $row['title'] . "'><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>Daftar</button></td>";
                } else if($_SESSION['role'] == 'admin') {
                    echo ("<td>
                            <a href='scholarships/edit?user_id=".$row['user_id'] ."&scholarship_id=".$row['scholarship_id']."'>
                                <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>Edit</button>
                            </a>
                            <a href='scholarships/delete?user_id=".$row['user_id'] ."&scholarship_id=".$row['scholarship_id']."'>
                                <button type='button' onclick = 'return deleteConfirmation()' class='btn btn-danger' data-toggle='modal' data-target='#exampleModalCenter'>Delete</button>
                            </a>
                        </td>");
                }
                    echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <div class="pagination-button">
        <?php
        if ($data['itemsPerPage'] == $data['totalScholarships']) {
            echo "<a href='scholarships?page=1&itemsPerPage=all'>1</a>";
        } else {
            $totalPages = ceil($data['totalScholarships'] / $data['itemsPerPage']);
            for ($i = 1; $i <= $totalPages; $i++) {
                $isActive = $i == $data['currentPage'] ? 'active' : '';
                echo "<a href='scholarships?page=$i&itemsPerPage=" . $data['itemsPerPage'] . "' class='$isActive'>" . $i . "</a> ";
            }
        }
        ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('form').submit(function(e) {
            e.preventDefault();

            var searchQuery = $('#search').val();
            $.ajax({
                type: 'GET',
                url: '/scholarships/search',
                data: {
                    search: searchQuery
                },
                success: function(data) {
                    $('.scholarship-body tbody').html(data);
                }
            });
        });

        $('#search').on('input', function() {
            var searchQuery = $(this).val();
            $.ajax({
                type: 'GET',
                url: '/scholarships/search',
                data: {
                    search: searchQuery
                },
                success: function(data) {
                    $('.scholarship-body tbody').html(data);
                }
            });
        });
    });
</script>

<script>
    function deleteConfirmation(){
        var result = confirm("Apakah ingin melakukan penghapusan?");
        return result;
    }
</script>
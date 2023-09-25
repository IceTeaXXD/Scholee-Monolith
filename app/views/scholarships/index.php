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
                                <option value="5" <?php if (isset($_GET['itemsPerPage']) && $_GET['itemsPerPage'] === '5') echo 'selected'; ?>>5</option>
                                <option value="10" <?php if (isset($_GET['itemsPerPage']) && $_GET['itemsPerPage'] === '10') echo 'selected'; ?>>10</option>
                                <option value="15" <?php if (isset($_GET['itemsPerPage']) && $_GET['itemsPerPage'] === '15') echo 'selected'; ?>>15</option>
                                <option value="20" <?php if (isset($_GET['itemsPerPage']) && $_GET['itemsPerPage'] === '20') echo 'selected'; ?>>20</option>
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
                echo "<td><a href='scholarships?item_id=" . $row['title'] . "'><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>Daftar</button></td>";
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<link rel="stylesheet" type="text/css" href="<?= $data['style']; ?>">
<link rel="stylesheet" type="text/css" href="/public/css/search.css">
<link rel="stylesheet" type="text/css" href="/public/css/slider.css">
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
        <div class="slidecontainer">
            <input type="range" min="1" max="1000000" value="500000" class="slider" id="range">
            <p>Coverage: <span id="coverage"></span></p>
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
                            <select name="itemsPerPage" id="itemsPerPage">
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
        <tbody id="scholarship-list">
            <!-- Inject by js here -->
        </tbody>
    </table>
    <div class="pagination-button" id="pagination-button">
        <!-- Inject by js here -->
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
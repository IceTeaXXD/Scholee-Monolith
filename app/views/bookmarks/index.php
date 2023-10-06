<link rel="stylesheet" type="text/css" href="<?= $data['style']; ?>">
<link rel="stylesheet" type="text/css" href="/public/css/search.css">
<div class="scholarship-body">
    <table class="container">
        <div class="search-form">
            <body>
                <form autocomplete="off">
                    <label for="search">Search</label>
                    <input id="search-bookmark" type="search" pattern=".*\S.*" required>
                    <span class="caret"></span>
                </form>
            </body>
        </div>
        <div class="slide-bookmark">
            <input type="range" min="1" max="1000000" value="500000" class="slider" id="slide-bookmark"> 
            <p>Coverage: $  <span id="coverage">500000</span></p> 
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
        <tbody id = "bookmark-list">
            <!-- iNJECT JS -->
        </tbody>
    </table>
    <div class="pagination-button" id="pagination-button-bm">
        <!-- Inject by js -->
    </div>
</div>

<script src="/public/js/bookmark.js"></script>
<script src="/public/js/scholarships.js"></script>
<script>
    var userRole = "<?php echo $_SESSION['role']; ?>";
    var userId = "<?php echo $_SESSION['user_id']; ?>";
</script>
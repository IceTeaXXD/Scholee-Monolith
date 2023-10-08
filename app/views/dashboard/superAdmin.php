<div class="scholarships">
    <h2>User</h2>
    <div class="carousel-window">
        <button class="carousel-nav carousel-prev" onclick="prevSlide()">❮</button>
        <ul class="scholarship-list">
            <?php 
            while ($row = mysqli_fetch_array($data['user'])) {
                echo '<li class="scholarship-item">';
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p> Nama : " . $row['role'] . "</p>";
                echo "<p> Email : " . $row['email'] . "</p>";
                echo '</li>';
            }
            ?>
        </ul>
        <button class="carousel-nav carousel-next" onclick="nextSlide()">❯</button>
    </div>
</div>
</div>
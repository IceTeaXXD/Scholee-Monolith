<div class="scholarships">
    <h2>You have several file queued to review</h2>
    <div class="carousel-window">
        <button class="carousel-nav carousel-prev" onclick="prevSlide()">❮</button>
        <ul class="scholarship-list">
            <?php 
            while ($row = mysqli_fetch_array($data['reviews'])) {
                echo '<li class="scholarship-item">';
                echo "<h3>" . $row['review_status'] . "</h3>";
                echo "<p> File : " . $row['link'] . "</p>";
                echo "<p> Type : " . $row['type'] . "</p>";
                echo '<button class="viewMore-button" onclick="viewMoreReviews()">';
                echo 'View More';
                echo '</button>';
                echo '</li>';
            }
            ?>
        </ul>
        <button class="carousel-nav carousel-next" onclick="nextSlide()">❯</button>
    </div>
</div>
</div>
<div class="user-actions">
        <button class="action-button" onclick="uploadDocument()">Upload Document</button>
        <button class="action-button" onclick="applyScholarship()">Apply for Scholarship</button>
</div>
<div class="scholarships">
    <h2>Open Scholarships</h2>
    <div class="carousel-window">
        <button class="carousel-nav carousel-prev" onclick="prevSlide()">❮</button>
        <ul class="scholarship-list">
            <?php 
            while ($row = mysqli_fetch_array($data['scholarships'])) {
                echo '<li class="scholarship-item">';
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['short_description'] . "</p>";
                echo '<button class="viewMore-button" onclick="viewMoreClicked(' . $row["user_id"] . ',' . $row["scholarship_id"] . ')">';
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
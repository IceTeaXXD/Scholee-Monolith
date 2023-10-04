<div class="description">
    <div class="container">
        <h1><?php echo $data['title']; ?></h1>
        <br>
        <p><?php echo $data['short_description']; ?></p>
        <br>
        <p><?php echo $data['description']; ?></p>
        <div class="info">
            <h2>Information</h2>
            <p><span class="label">Coverage:</span> $<?php echo number_format($data['coverage'], 0, ',', '.'); ?></p>
            <p><span class="label">Contact Name:</span> <?php echo $data['contact_name']; ?></p>
            <p><span class="label">Contact Email:</span> <?php echo $data['contact_email']; ?></p>
        </div>
        <div class="btn-container">
        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter' onclick="bookmark(<?php echo $data['user_id']; ?>, <?php echo $data['scholarship_id']; ?>)">Bookmark</button>
        </div>
    </div>
</div>

<script src="/public/js/bookmark.js"></script>
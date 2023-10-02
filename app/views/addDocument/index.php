<div class = "add-beasiswa">
    <h1>Add Document</h1>
    <div class="form">
        
        <form method = "post" action = "/api/review/add.php" enctype="multipart/form-data">
            <label for="file">Upload File</label>
            <input type="file" name="document" id = "file" required />

            <button type = "submit" class="save-btn">Tambah Dokumen</button>
            <a href = "/dashboard" class="cancel-btn">Cancel</a>
        </form>

    </div>
</div>
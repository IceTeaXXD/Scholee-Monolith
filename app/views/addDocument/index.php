<div class="add-beasiswa">
    <h1>Add Document</h1>
    <div class="form">
        <form action="javascript:;" onsubmit="return submitForm()" enctype="multipart/form-data">
            <label for="file">Upload File</label>
            <input type="file" name="document" id="file" required />

            <button type="submit" class="save-btn">Tambah Dokumen</button>
            <a href="/dashboard" class="cancel-btn">Cancel</a>
        </form>
    </div>
</div>
<script src="../../../public/js/addDocument.js"></script>
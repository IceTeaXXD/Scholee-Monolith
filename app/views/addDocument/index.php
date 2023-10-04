<div class="add-beasiswa">
    <h1>Add Document</h1>
    <div class="form">
        <form action="javascript:;" onsubmit="return submitForm()" enctype="multipart/form-data">
            <div class="input-container">
                <label for="file">Upload File</label>
                <input type="file" name="document" id="file" required />
            </div>
            <div class="button-container">
                <button type="submit" class="save-btn">Tambah Dokumen</button>
                <a href="/dashboard" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script src="../../../public/js/addDocument.js"></script>
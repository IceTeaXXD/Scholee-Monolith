<div class="add-document">
    <h1 id="assignment_name"></h1>
    <p id="description"></p>
    <div class="form">
        <form action="javascript:;" onsubmit="return submitForm()" enctype="multipart/form-data">
            <div class="input-container">
                <label for="file">Upload File</label>
                <input type="file" name="document" id="file" required accept=".mp4, .pdf"/>
            </div>
            <div class="button-container">
                <a href="/dashboard" class="cancel-btn">Cancel</a>
                <button type="submit" class="save-btn">Tambah Dokumen</button>
            </div>
        </form>
    </div>
    <div id="notification">
        <!-- Inject from js -->
    </div>
</div>

<script>
    var sid = <?php echo $_GET['sid'];?>;
    var aid = <?php echo $_GET['aid'];?>;
    const uid = <?php echo json_encode($data['user_id']); ?>;
</script>
<script src="/public/js/submit.js"></script>
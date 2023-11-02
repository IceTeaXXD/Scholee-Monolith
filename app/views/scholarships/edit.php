<?php
$row = mysqli_fetch_array($data['row']);

$types = [];
while($type = mysqli_fetch_array($data['type'])){
    echo $type['type'];
    $types[] = $type['type'];
}

$formatType = implode(', ', $types);
?>
<div class = "add-beasiswa">
    <h1>Edit Beasiswa</h1>
    <div class="form">
        
        <form action="javascript:;" onsubmit="return submitForm()">
            <label for="scholarshipname">Scholarship Name</label>
            <input type="text" name="title" id = "scholarshipname" value="<?php echo $row['title'];?>"required />
            <input type="hidden" name="scholarship_id" value="<?php echo $row['scholarship_id'];?>">
            
            <label for="description">Scholarship Description</label>
            <textarea id="description" name="description" rows="10" required /><?php echo $row['description'];?></textarea>

            <label for="shortDesc">Scholarship Description</label>
            <textarea id="shortDesc" name="shortDescription" rows="10" required /><?php echo $row['short_description'];?></textarea>

            <label for="coverage">Coverage</label>
            <input type="text" name="coverage" id="coverage" value = "<?php echo $row['coverage'];?>" required />

            <label for="contactname">Contact Name</label>
            <input type="text" name="contact_name" id="contact_name" value = "<?php echo $row['contact_name'];?>" required />

            <label for="contactemail">Contact Email</label>
            <input type="email" name="contact_email" id="contact_email" value = "<?php echo $row['contact_email'];?>" required />

            <label for="type">Scholarship Type(s)</label>
            <input type="text" name="type" id="type" value = "<?php echo $formatType;?>" required />

            <button type = "submit" class="save-btn">Edit Beasiswa</button>
            <a href = "/scholarships" class="cancel-btn">Cancel</a>
        </form>

    </div>
</div>
<script src="../../../public/js/updateBeasiswa.js"></script>
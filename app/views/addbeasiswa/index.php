<div class = "add-beasiswa">
    <h1>Add Beasiswa</h1>
    <div class="form">
        
        <form action="javascript:;" onsubmit="return submitForm()">
            <label for="scholarshipname">Scholarship Name</label>
            <input type="text" name="title" id = "scholarshipname" required />
            
            <label for="description">Scholarship Full Description</label>
            <textarea id="description" name="description" rows="10" required /></textarea>

            <label for="shortdescription">Scholarship Short Description</label>
            <textarea id="shortdescription" name="shortDescription" rows="10" required /></textarea>

            <label for="coverage">Coverage</label>
            <input type="text" name="coverage" id="coverage" required />

            <label for="contactname">Contact Name</label>
            <input type="text" name="contact_name" id="contact_name" required />

            <label for="contactemail">Contact Email</label>
            <input type="email" name="contact_email" id="contact_email" required />

            <label for="type">Scholarship Type(s)</label>
            <input type="text" name="type" id="type" required />
            <div class="flex-button">
                <a href = "/dashboard" class="cancel-btn">Cancel</a>
                <button type = "submit" class="save-btn">Tambah Beasiswa</button>
            </div>
        </form>

    </div>
</div>
<script src="../../../public/js/addScholarship.js"></script>
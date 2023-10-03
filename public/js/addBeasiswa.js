async function addBeasiswa() {
    try {
        const title = document.getElementById("scholarshipname").value;
        const description = document.getElementById("description").value;
        const coverage = document.getElementById("coverage").value;
        const contactName = document.getElementById("contact_name").value;
        const contactEmail = document.getElementById("contact_email").value;
        const type = document.getElementById("type").value;

        const formData = new FormData();
        formData.append("title", title);
        formData.append("description", description);
        formData.append("coverage", coverage);
        formData.append("contact_name", contactName);
        formData.append("contact_email", contactEmail);
        formData.append("type", type);

        const response = await fetch('/api/scholarship/add.php', {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();

        if (data.status === "success") {
            window.location.href = "../../scholarships";
        } else {
            console.error("Error:", data.message);
        }
    } catch (err) {
        console.error("Error:", err);
    }
}

const submitForm = () => {
    console.log('submitting');
    const title = document.getElementById('scholarshipname').value;
    const description = document.getElementById('description').value;
    const shortDescription = document.getElementById('shortdescription').value;
    const coverage = document.getElementById('coverage').value;
    const contactName = document.getElementById('contact_name').value;
    const contactEmail = document.getElementById('contact_email').value;
    const type = document.getElementById('type').value;

    console.log(title, description, coverage, contactName, contactEmail, type, shortDescription);
    if (!title || !description || !coverage || !contactName || !contactEmail || !type || !shortDescription) {
        alert('Please fill out all fields');
        return false;
    }

    const data = new FormData();
    data.append("title", title);
    data.append("description", description);
    data.append("coverage", coverage);
    data.append("contact_name", contactName);
    data.append("contact_email", contactEmail);
    data.append("type", type);
    data.append("short_description", shortDescription);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/scholarship/add.php');
    console.log('opened');
    console.log('set header');
    xhr.onload = () => {
        const res = JSON.parse(xhr.response);
        console.log("response");
        console.log(xhr.response);
        if (res.status === 'success') {
            alert('Scholarship created successfully');
            window.location.href = '/scholarships';
        } else {
            alert(res.error);
        }
    };
    xhr.send(data);
    console.log('sent');
    return false;
}
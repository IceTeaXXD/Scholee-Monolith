function submitForm() {
    const fileInput = document.getElementById('file');
    const formData = new FormData();
    formData.append('document', fileInput.files[0]);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/review/add.php', true);
    
    xhr.onload = () => {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.status === 'success') {
                alert('Document added successfully');
                window.location.href = '/reviews';
            } else {
                alert('Failed to add document');
            }
        } else {
            alert('Failed to send the request. Server responded with status: ' + xhr.status);
        }
    };

    xhr.send(formData);

    return false; 
}
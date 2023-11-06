function submitForm() {
    const fileInput = document.getElementById('file');
    const formData = new FormData();
    formData.append('document', fileInput.files[0]);

    if (!isFileExtensionValid(fileInput)) {
        alert('Invalid file type. Only .mp4 and .pdf files are allowed.');
        return false;
    }

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

function isFileExtensionValid(fileInput) {
    if (fileInput.files.length === 0) {
      return false;
    }
  
    const file = fileInput.files[0];
    const fileName = file.name;
    const fileExtension = fileName.slice(((fileName.lastIndexOf(".") - 1) >>> 0) + 2);
    const allowedExtensions = ['.mp4', '.pdf'];

    console.log(fileExtension)
  
    return allowedExtensions.includes('.' + fileExtension);
  }
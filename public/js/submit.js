const render = () => {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `http://localhost:5001/api/assignment/${sid}/${aid}`)
    xhr.setRequestHeader("user_id", uid);
    xhr.onload = () => {
        const res = JSON.parse(xhr.response);
        if (res.status === 'success') {

            title.innerHTML = res.data.assignments[0].assignment_name
            description.innerHTML = res.data.assignments[0].assignment_description

        }
    }

    xhr.send()
}
const notificationElement = document.getElementById('notification');
const title = document.getElementById("assignment_name");
const description = document.getElementById("description");
const submitForm = () => {
    const xhr = new XMLHttpRequest();
    const formData = new FormData();

    // Get the file input element
    const fileInput = document.getElementById('file');

    // Checking File Types
    const allowedFileTypes = ['application/pdf', 'video/mp4'];
    if (!allowedFileTypes.includes(fileInput.files[0].type)) {
        notificationElement.classList.add('error');
        notificationElement.innerHTML = '<i class="fas fa-times-circle"></i> Hanya File MP4 dan PDF yang diperbolehkan!';
        return false;
    }

    // Check file size (in bytes)
    const maxSize = 1024 * 1024; // 1 MB
    if (fileInput.files[0].size > maxSize) {
        notificationElement.classList.add('error');
        notificationElement.innerHTML = '<i class="fas fa-times-circle"></i>Ukuran file maksimal 1MB';
        return false;
    }

    // Append data to the FormData object
    formData.append("uid", uid);
    formData.append("file", fileInput.files[0]);

    xhr.open("POST", `http://localhost:5001/api/files/scholarship/${sid}/assignment/${aid}`);

    xhr.onload = () => {
        const res = JSON.parse(xhr.response);

        if (res.status === 'success') {
            notificationElement.classList.add('success');
            notificationElement.innerHTML = '<i class="fas fa-check-circle"></i> Berhasil Mengupload assignment';
        } else {
            notificationElement.classList.add('error');
            notificationElement.innerHTML = '<i class="fas fa-times-circle"></i> Gagal Mengupload Assignment';
        }
    }

    xhr.send(formData);
}



document.addEventListener("DOMContentLoaded", render);
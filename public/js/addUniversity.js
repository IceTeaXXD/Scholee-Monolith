const submitForm = () => {
    const university = document.getElementById('file');
    const formData = new FormData();
    formData.append('university', university.value);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/api/university/add.php");
    xhr.onload = () => {
        const res = JSON.parse(xhr.response);
        if(res.status === 'success'){
            alert('University created successfully');
            window.location.href = '/dashboard';
        }else{
            alert('University Failed to be created');
        }
    }

    xhr.send(formData);

    return false;
}
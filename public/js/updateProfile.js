const submitForm = () => {
    const fullName = document.getElementById('fullName').value;
    const university = document.getElementById('university').value;
    const major = document.getElementById('major').value;
    const level = document.getElementById('level').value;
    const street = document.getElementById('street').value;
    const city = document.getElementById('city').value;
    const zipcode = document.getElementById('zipcode').value;
    const profilepic = document.getElementById('profileUpload').files[0];
    const formData = new FormData();
    formData.append('name', fullName);
    formData.append('university', university);
    formData.append('major', major);
    formData.append('level', level);
    formData.append('street', street);
    formData.append('city', city);
    formData.append('zipcode', zipcode);
    formData.append('profilepic', profilepic);

    console.log(fullName, university, major, level, street, city, zipcode);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/profile/update.php');
    xhr.onload = () => {
        const response = JSON.parse(xhr.responseText);
        console.log('Response:', response);

        if (response.status === 'success') {
            alert('Profile updated successfully');
            window.location.href = '/profile';
        } else {
            alert('Failed to update profile');
        }
    };

    xhr.send(formData);
    return false;
}
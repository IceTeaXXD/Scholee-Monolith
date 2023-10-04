const submitForm = () => {
    const fullNameInput = document.getElementById('fullName');
    const universityInput = document.getElementById('university');
    const majorInput = document.getElementById('major');
    const levelInput = document.getElementById('level');
    const streetInput = document.getElementById('street');
    const cityInput = document.getElementById('city');
    const zipcodeInput = document.getElementById('zipcode');
    const profileUploadInput = document.getElementById('profileUpload');
    const organizationInput = document.getElementById('organization');
    const occupationInput = document.getElementById('occupation');

    const fullName = fullNameInput ? fullNameInput.value : null;
    const university = universityInput ? universityInput.value : null;
    const major = majorInput ? majorInput.value : null;
    const level = levelInput ? levelInput.value : null;
    const street = streetInput ? streetInput.value : null;
    const city = cityInput ? cityInput.value : null;
    const zipcode = zipcodeInput ? zipcodeInput.value : null;
    const profilepic = profileUploadInput ? profileUploadInput.files[0] : null;
    const organization = organizationInput ? organizationInput.value : null;
    const occupation= occupationInput ? occupationInput.value : null;

    const formData = new FormData();
    formData.append('name', fullName);
    formData.append('university', university);
    formData.append('major', major);
    formData.append('level', level);
    formData.append('street', street);
    formData.append('city', city);
    formData.append('zipcode', zipcode);
    formData.append('profilepic', profilepic);
    formData.append('organization', organization);
    formData.append('occupation', occupation);

    console.log(fullName, university, major, level, street, city, zipcode, profilepic);

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
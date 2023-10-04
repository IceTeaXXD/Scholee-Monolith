document.querySelector('.profile-form').addEventListener('submit', function (e) {
    e.preventDefault(); 
    const searchParams = new URLSearchParams(window.location.search);

    const formData = new FormData(this);
    formData.append("user_id", searchParams.get('user_id'));
    formData.append("role", searchParams.get('role'));
    formData.append("email", searchParams.get('email'));

    const xhr = new XMLHttpRequest();

    xhr.open('POST', '/api/profile/updateAdmin.php', true);
    
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            console.log('Response:', response);

            if (response.status === 'success') {
                alert('Profile updated successfully');
                window.location.href = '/admin/list';
            } else {
                alert('Failed to update profile');
            }
        } else {
            alert('Error: ' + xhr.status);
        }
    };

    xhr.send(formData);
});

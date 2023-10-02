const submitForm = () => {
    const userName = document.getElementById('scholarshipname').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;
    if (!userName || !email || !password || !role) {
        alert('Please fill out all fields');
        return false;
    }

    // console.log(userName, email, password, role);

    const data = new FormData();
    data.append("name", userName);
    data.append("email", email);
    data.append("password", password);
    data.append("role", role);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/user/register.php');
    xhr.onload = () => {
        const res = JSON.parse(xhr.response);
        if (res.status === 'success') {
            // send a notification popup
            alert('User created successfully');
        } else {
            alert(res.error);
        }
    };
    xhr.send(data);
    console.log('sent')
    return false;
}
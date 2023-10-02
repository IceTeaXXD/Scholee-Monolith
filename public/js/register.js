const submitForm = () => {
    const name = document.getElementById('fullname').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    if (!name || !email || !password) {
        alert('Please fill out all fields');
        return false;
    }
    
    // check ameil and password 
    if (!isValidEmail(email) || !isValidPassword(password)) {
        alert('Invalid email or password!');
        return false;
    }
    const data = new FormData();
    data.append("name", name);
    data.append("email", email);
    data.append("password", password);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/user/register.php');
    xhr.onload = () => {
        const res = JSON.parse(xhr.response);
        if (res.status === 'success') {
            alert('User created successfully');
            // go to login
            window.location.href = "../../login";
        } else {
            alert(res.error);
        }
    }
    xhr.send(data);
    console.log('sent')
    return false;
}

function isValidEmail(email) {
    const regex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
    return regex.test(email);
}

function isValidPassword(password) {
    const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
    return regex.test(password);
}
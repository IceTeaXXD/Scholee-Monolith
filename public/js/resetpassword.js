const form = document.querySelector('form');
form.addEventListener('submit', function (event) {
    event.preventDefault(); // prevent the form from submitting normally
    const xhr = new XMLHttpRequest();
    // if email form exists, send email
    const token = window.location.search.split('=')[1];
    if (token === undefined) {
        xhr.open('POST', '/api/user/sendresetpassword.php');
        // set the success text to a loading message
        const succ = document.querySelector('.SuccessText');
        succ.textContent = 'Loading...';
        succ.style.display = 'block';
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                if (response.status === 'success') {
                    // window.location.href = '/login';
                    const succ = document.querySelector('.SuccessText');
                    succ.textContent = response.message;
                    succ.style.display = 'block';
                } else {
                    const error = document.querySelector('.ErrorText');
                    error.textContent = response.message;
                    error.style.display = 'block';
                    succ.style.display = 'none';
                    document.querySelector('.Button').style.marginTop = '0px';
                }
            } else {
                console.error('Server returned error ' + xhr.status);
            }
        };
    } else { // There is a token, reset the password
        xhr.open('POST', '/api/user/resetpassword.php');
        if (form.password.value !== form.password2.value) {
            const error = document.querySelector('.ErrorText');
            error.textContent = 'Passwords do not match';
            error.style.display = 'block';
            document.querySelector('.ErrorText').style.marginTop = '150px';
            document.querySelector('.Button').style.marginTop = '0px';
            return;
        }

        if (!isValidPassword(password.value)) {
            const error = document.querySelector('.ErrorText');
            error.textContent = 'Password must be a combination of minimum 8 letters, 1 uppercase, and numbers';
            error.style.display = 'block';
            document.querySelector('.ErrorText').style.marginTop = '150px';
            document.querySelector('.Button').style.marginTop = '0px';
            return;
        }
        // token is from the url, print the token
        console.log(token);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                if (response.status === 'success') {
                    window.location.href = '/login';
                } else {
                    const error = document.querySelector('.ErrorText');
                    error.textContent = response.message;
                    error.style.display = 'block';
                    document.querySelector('.ErrorText').style.marginTop = '150px';
                    document.querySelector('.Button').style.marginTop = '0px';
                }
            } else {
                console.error('Server returned error ' + xhr.status);
            }
        };
    }
    xhr.send(new FormData(form));
});

function isValidPassword(password) {
    // password must be atleast 1 uppercase, 1 number, and 8 characters long
    const re = /^(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/;
    return re.test(password);
}
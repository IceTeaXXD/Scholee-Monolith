const form = document.querySelector('form');
form.addEventListener('submit', function (event) {
    event.preventDefault(); // prevent the form from submitting normally
    if (!isValidPassword(password.value)) {
        const error = document.querySelector('.ErrorText');
        error.textContent = 'Password must be a combination of minimum 8 letters, 1 uppercase, and numbers';
        error.style.display = 'block';
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/user/register.php');
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                window.location.href = '/login';
            } else {
                const error = document.querySelector('.ErrorText');
                console.log(response.message);
                error.textContent = response.message;
                error.style.display = 'block';
            }
        } else {
            console.error('Server returned error ' + xhr.status);
        }
    };
    xhr.send(new FormData(form));
});

function isValidPassword(password) {
    // password must be atleast 1 uppercase, 1 number, and 8 characters long
    const re = /^(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/;
    return re.test(password);
}
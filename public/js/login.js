const form = document.querySelector('form');
form.addEventListener('submit', function (event) {
    event.preventDefault(); // prevent the form from submitting normally

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/user/login.php');
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            console.log(response);
            if (response.status === 'success') {
                window.location.href = '/dashboard';
            } else {
                const error = document.querySelector('.ErrorText');
                error.textContent = response.message;
                error.style.display = 'block';
                document.querySelector('.ErrorText').style.marginTop = '50px';
                document.querySelector('.Button').style.marginTop = '80px';
            }
        } else {
            console.error('Server returned error ' + xhr.status);
        }
    };
    xhr.send(new FormData(form));
});
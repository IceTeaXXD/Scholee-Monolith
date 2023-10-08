window.onload = function () {
    if (window.location.href.includes('?token=')) {
        const token = window.location.href.split('?token=')[1];
        const data = new FormData();
        data.append('token', token);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/user/verify.php');
        xhr.send(data);
        xhr.onload = () => {
            const response = JSON.parse(xhr.responseText);
            console.log('Response:', response);
            if (response.status === 'success') {
            } else {
                document.querySelector('.Title').textContent = 'Failed to verify user';
                document.querySelector('.Message').textContent = response.message;
            }
        };
    }
};
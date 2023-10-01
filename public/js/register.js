document.getElementById('register-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    try {
        let response = await fetch('/api/user/register.php', {
            method: 'POST',
            body: formData
        });

        let data = await response.json();

        if (data.status === 'success') {
            window.location.href = "../../login";
        } else {
            let errorDiv = document.querySelector('.alert-danger');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger';
                document.querySelector('.form').prepend(errorDiv);
            }
            errorDiv.innerText = data.error;
        }
    } catch (err) {
        console.error("There was an error:", err);
    }
});
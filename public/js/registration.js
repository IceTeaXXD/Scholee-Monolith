const getRegistration = () => {
    let scholarshipsTableBody = document.getElementById("application-list");
    scholarshipsTableBody.innerHTML = "";

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/registration/registration.php");

    xhr.onload = () => {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            response.data.forEach(element => {
                let row = `
                <tr>
                    <td class="comment">${element.title}</td>
                    <td class="comment">${element.description}</td>
                    <td class="comment">$${element.coverage.toLocaleString("id-ID")}</td>
                    <td class="comment">${element.status}</td>
                </tr>`
                scholarshipsTableBody.innerHTML += row;
            });
        } else {
            alert('Failed to send the request. Server responded with status: ' + xhr.status);
        }
    }

    xhr.send()
}

document.addEventListener("DOMContentLoaded", getRegistration);
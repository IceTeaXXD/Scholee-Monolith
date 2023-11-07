const getApplications = () => {
    let scholarshipsTableBody = document.getElementById("application-list");
    scholarshipsTableBody.innerHTML = "";

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/application/application.php");

    xhr.onload = () => {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if(
                response.status !== "error" &&
                response.data &&
                response.data.length > 0
            ){
                response.data.forEach(element => {
                    let row = `
                    <tr>
                        <td class="comment">${element.title}</td>
                        <td class="comment">${element.description}</td>
                        <td class="comment">$${element.coverage.toLocaleString("id-ID")}</td>
                        <td class="comment">${element.status}</td>
                        ${element.status == 'accepted' ? '<td class="comment"><button class="button-style" onclick="">View Assignments</button></td>' : ''}
                    </tr>`
                    // To-Do: Create a Function to move to /assignments. Pass along the user_id_student, user_id_scholarship, and scholarship_id
                    scholarshipsTableBody.innerHTML += row;
                });
            }else{
                let row = '<tr><td colspan="6">No applications found.</td></tr>';
                scholarshipsTableBody.innerHTML += row;
            }
        } else {
            alert('Failed to send the request. Server responded with status: ' + xhr.status);
        }
    }

    xhr.send()
}

document.addEventListener("DOMContentLoaded", getApplications);
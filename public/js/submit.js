const render = () => {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `http://localhost:5001/api/assignment/${sid}/${aid}`)
    xhr.setRequestHeader("user_id", uid);
    xhr.onload = () => {
        const res = JSON.parse(xhr.response);
        console.log(res.data);
        console.log(res.data.assignments[0])
        if (res.status === 'success') {

            title.innerHTML = res.data.assignments[0].assignment_name
            description.innerHTML = res.data.assignments[0].assignment_description

        }
    }

    xhr.send()
}
const title = document.getElementById("assignment_name");
const description = document.getElementById("description");
const submitForm = () => {
    const xhr = new XMLHttpRequest();
    const formData = new FormData();

    // Get the file input element
    const fileInput = document.getElementById('file');

    // Append data to the FormData object
    formData.append("uid", uid);
    formData.append("file", fileInput.files[0]); // Assuming fileInput is your file input element

    xhr.open("POST", `http://localhost:5001/api/files/scholarship/${sid}/assignment/${aid}`);

    xhr.onload = () => {
        const res = JSON.parse(xhr.response);

        if (res.status === 'success') {
            // Update the HTML elements with the response data
            document.getElementById('assignment_name').innerHTML = res.data.assignment_name;
            document.getElementById('description').innerHTML = res.data.assignment_description;
        }
    }

    xhr.send(formData);
}



document.addEventListener("DOMContentLoaded", render);
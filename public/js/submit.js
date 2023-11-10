const render = () => {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `http://localhost:5000/api/assignment/${sid}/${aid}`)

    xhr.onload = () => {
        const res = JSON.parse(xhr.response);
        console.log(res.data);

        if (res.status === 'success') {

            title.innerHTML = res.data.assignment_name
            description.innerHTML = res.data.assignment_description

        }
    }

    xhr.send()
}
const title = document.getElementById("assignment_name");
const description = document.getElementById("description");

const submitForm = () => {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", `http://localhost:5000/api/files/scholarship/${sid}/assignment/${aid}`)

    xhr.onload = () => {
        const res = JSON.parse(xhr.response);
        console.log(res.data);

        if (res.status === 'success') {

            title.innerHTML = res.data.assignment_name
            description.innerHTML = res.data.assignment_description

        }
    }

    const body = {
        "uid": uid,
        "file_path": file_path
    }

    xhr.send(body)
}

document.addEventListener("DOMContentLoaded", render);
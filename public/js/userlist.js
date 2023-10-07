const modal = document.getElementById("modal");
const userName = document.getElementById("modal-name");
var $userID = 0;

function deleteConfirmation($name, $uid) {
    modal.style.display = "block";
    userName.innerHTML = $name;
    $userID = $uid;
}

function deleteUser() {
    const data = new FormData();
    data.append("user_id", $userID);

    const xmr = new XMLHttpRequest();
    xmr.open("POST", "/api/user/delete.php");
    xmr.send(data);
    xmr.onload = () => {
        const response = JSON.parse(xmr.responseText);
        console.log('Response:', response);

        if (response.status === 'success') {
            location.reload();
        } else {
            alert('Failed to delete user');
        }
    };
    return false;
}

function closeModal() {
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function debounce(fn, delay) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn.apply(this, args), delay);
    };
}
function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (decodeURIComponent(pair[0]) == variable) {
            return decodeURIComponent(pair[1]);
        }
    }
}

const debouncedSearch = debounce(getScholarship, 300);

function getScholarship(data = "") {
    const name = document.getElementById("search").value;
    const role = document.getElementById("role").value;
    // console.log("CALLED");
    // console.log(title, coverage);

    let base_url = "../../api/user/search.php";
    let add_url = "";

    add_url += "?name=" + name;
    add_url += "&role=" + role;

    const page = getQueryVariable("page") || 1;
    add_url += "&page=" + page;

    const final_url = base_url + add_url;
    console.log(final_url);
    const xhr = new XMLHttpRequest();
    xhr.open("GET", final_url, true);
    xhr.onload = function () {
        if (this.status == 200) {
            let response = JSON.parse(this.responseText);
            console.log(response);
            renderScholarships(response);
        }
    }
    xhr.send();
}

function renderScholarships(response) {
    let scholarshipsTableBody = document.getElementById('content');
    scholarshipsTableBody.innerHTML = '';

    if (response.status && response.status === 'error') {
        scholarshipsTableBody.innerHTML = 'No Users found';
    } else {
        response.data.forEach(scholarship => {
            let row = `
            <div class="box">
                <img class="profile" alt="user profile image" src="/public/image/profiles/${scholarship.image}">
                <h3 class="name">${scholarship.name}</h3>
                <div class="attribute">Role: ${scholarship.role}</div>
                <div class="attribute">Email: ${scholarship.email}</div>
                <a href="/admin/update?user_id=${scholarship.user_id}&email=${scholarship.email}&role=${scholarship.role}"> <button class="btn btn-primary">View More</button> </a>
                <button class="btn btn-danger" onclick="deleteConfirmation('${scholarship.name}','${scholarship.user_id}}')">Delete</button></a>
            </div>`;

            scholarshipsTableBody.innerHTML += row;
        });
    }
}

document.addEventListener("DOMContentLoaded", function () {
    let searchElement = document.getElementById("search");

    if (searchElement) {
        searchElement.addEventListener('input', function () {
            let currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set("page", 1);
            history.pushState(null, '', currentUrl);

            debouncedSearch();
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let roleElement = document.getElementById("role");

    if (roleElement) {
        roleElement.addEventListener('input', function () {
            let currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set("page", 1);
            history.pushState(null, '', currentUrl);

            debouncedSearch();
        });
    }
});

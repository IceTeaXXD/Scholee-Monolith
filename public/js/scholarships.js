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
function getScholarship(data="") {
    const title = document.getElementById("search").value;
    const coverage = document.getElementById("range").value;
    const itemsPerPage = document.getElementById("itemsPerPage").value;
    // console.log("CALLED");
    // console.log(title, coverage);

    let base_url = "../../api/scholarship/search.php";
    let add_url = "";

    add_url += "?judul=" + title;
    add_url += "&coverage=" + coverage;
    add_url += "&itemsPerPage=" + itemsPerPage;

    const page = getQueryVariable("page") || 1;
    add_url += "&page=" + page;

    const final_url = base_url + add_url;
    console.log(final_url);
    const xhr = new XMLHttpRequest();
    xhr.open("GET", final_url, true);
    xhr.onload = function () {
        if (this.status == 200) {
            let response = JSON.parse(this.responseText);
            renderScholarships(response); 
            if (response.status !== 'error' && response.data && response.data.length > 0) {
                renderPagination(response.currentPage, response.total, itemsPerPage);
                console.log('called');
            } else {
                // remove pagination injection
                document.getElementById("pagination-button").innerHTML = '';
            }
        }
    }
    xhr.send();
}

function renderScholarships(response) {
    let scholarshipsTableBody = document.getElementById('scholarship-list');
    scholarshipsTableBody.innerHTML = '';

    if (response.status && response.status === 'error') {
        scholarshipsTableBody.innerHTML = '<tr><td colspan="6">No scholarships found.</td></tr>';
    } else if (response.data && Array.isArray(response.data)) {
        response.data.forEach(scholarship => {
            let types = scholarship.types.join(', ');
            let row = `
            <tr>
                <td>${scholarship.title}</td>
                <td>${scholarship.short_description}</td>
                <td>${scholarship.coverage}</td>
                <td>${types}</td>
                <td><button class="button-style" onclick="redirectToScholarships(${scholarship.user_id}, ${scholarship.scholarship_id})">View More</button></td>
                <td><button class="button-style" onclick="bookmark(${scholarship.user_id}, ${scholarship.scholarship_id})"><i class="fas fa-bookmark"></i></button></td>
            </tr>`;
            scholarshipsTableBody.innerHTML += row;
        });
    }
}


function renderPagination(currentPage, totalItems, itemsPerPage) {
    console.log(`Rendering Pagination: currentPage=${currentPage}, totalItems=${totalItems}, itemsPerPage=${itemsPerPage}`);
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    let paginationHtml = '';

    for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `<button onclick="changePage(${i})">${i}</button>`;
    }

    document.getElementById("pagination-button").innerHTML = paginationHtml;
    updateActiveButton(currentPage);
}

function updateActiveButton(currentPage) {
    const buttons = document.querySelectorAll(".pagination-button button");
    buttons.forEach((button, index) => {
        if ((index + 1) == currentPage) {
            button.classList.add("active");
        } else {
            button.classList.remove("active");
        }
    });
}

function changePage(page) {
    let currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set("page", page);
    history.pushState(null, '', currentUrl);
    getScholarship();
}
document.addEventListener("DOMContentLoaded", function() {
    const currentPage = getQueryVariable("page") || 1;
    updateActiveButton(currentPage);
});

// update url without refresh
document.getElementById("itemsPerPage").addEventListener('change', function() {
    let currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set("page", 1);
    history.pushState(null, '', currentUrl);
    
    getScholarship();
});
// update url without refresh for search
document.getElementById("search").addEventListener('input', function() {
    let currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set("page", 1);
    history.pushState(null, '', currentUrl);
    
    debouncedSearch();
});

document.getElementById("search").addEventListener('input', debouncedSearch);
document.getElementById("range").addEventListener('input', debouncedSearch);

function redirectToScholarships(uid, sid) {
    window.location.href = `/scholarships/${uid}/${sid}`;
}

var slider = document.getElementById("range");
var output = document.getElementById("coverage");
output.innerHTML = slider.value; 

slider.oninput = function () {
    output.innerHTML = "$" + this.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};

const coverage = document.getElementById("coverage");
const value = document.getElementById("range").value;
coverage.innerHTML = "$" + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

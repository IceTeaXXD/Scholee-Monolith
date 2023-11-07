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
    const title = document.getElementById("search").value;
    const coverage = document.getElementById("range").value;
    const itemsPerPage = document.getElementById("itemsPerPage").value;

    let base_url = "/api/scholarship/search.php";
    let add_url = "";

    add_url += "?judul=" + title;
    add_url += "&coverage=" + coverage;
    add_url += "&itemsPerPage=" + itemsPerPage;
    console.log(isAscending);
    if (isAscending !== undefined) {
        add_url += "&sort=" + (isAscending ? "asc" : "desc");
    }

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
            if (
                response.status !== "error" &&
                response.data &&
                response.data.length > 0
            ) {
                renderPagination(
                    response.currentPage,
                    response.total,
                    itemsPerPage
                );
                console.log("called");
            } else {
                // remove pagination injection
                document.getElementById("pagination-button").innerHTML = "";
            }
        }
    };
    xhr.send();
}

function renderScholarships(response) {
    let scholarshipsTableBody = document.getElementById("scholarship-list");
    scholarshipsTableBody.innerHTML = "";
    let maxCoverage = 0;
    let minCoverage = 0;

    if (response.status && response.status === "error") {
        scholarshipsTableBody.innerHTML =
            '<tr><td colspan="6">No scholarships found.</td></tr>';
    } else if (userRole === "admin") {
        response.data.forEach((scholarship) => {
            if (scholarship.coverage > maxCoverage) {
                maxCoverage = scholarship.coverage;
            }
            if (scholarship.coverage < minCoverage) {
                minCoverage = scholarship.coverage;
            }
            let types = scholarship.types.join(", ");
            let row = `
            <tr>
                <td class='comment'>${scholarship.title}</td>
                <td class='comment'>${scholarship.short_description}</td>
                <td>$${scholarship.coverage.toLocaleString("id-ID")}</td>
                <td class='comment'>${types}</td>
                <td>
                    <button class="button-style" onclick="redirectToEditScholarship(${
                        scholarship.user_id
                    }, ${
                scholarship.scholarship_id
            })" aria-labelledby="editButtonLabel">Edit</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="deleteConfirmation(${
                        scholarship.user_id
                    }, ${
                scholarship.scholarship_id
            })" data-target="#deleteModal" aria-labelledby="deleteButtonLabel">Delete</button>
                </td>
                
            </tr>`;
            scholarshipsTableBody.innerHTML += row;
        });
    } else if (response.data && Array.isArray(response.data)) {
        response.data.forEach((scholarship) => {
            if (scholarship.coverage > maxCoverage) {
                maxCoverage = scholarship.coverage;
            }
            if (scholarship.coverage < minCoverage) {
                minCoverage = scholarship.coverage;
            }
            let types = scholarship.types.join(", ");
            let row = `
            <tr>
                <td class='comment'>${scholarship.title}</td>
                <td class='comment'>${scholarship.short_description}</td>
                <td>$${scholarship.coverage.toLocaleString("id-ID")}</td>
                <td class='comment'>${types}</td>
                <td><button class="button-style" onclick="redirectToScholarships(${
                    scholarship.user_id
                }, ${scholarship.scholarship_id})">View More</button>
                <button class="button-style" onclick="apply(${scholarship.user_id}, ${scholarship.scholarship_id})">Apply</button>
                <button class="button-style" onclick="bookmark(${
                    scholarship.user_id
                }, ${
                scholarship.scholarship_id
            })" aria-label="Bookmark Beasiswa"><i class="fas fa-bookmark"></i></button></td>
            </tr>`;
            scholarshipsTableBody.innerHTML += row;
        });
    }
}

function renderPagination(currentPage, totalItems, itemsPerPage) {
    currentPage = parseInt(currentPage);
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    let paginationHtml = "";

    if (currentPage > 1) {
        paginationHtml += `<button onclick="changePage(${currentPage - 1})" ${
            currentPage == 1 ? "disabled" : ""
        }>←</button>`;
    }

    for (let i = 1; i <= totalPages; i++) {
        if (
            i == 1 ||
            i == totalPages ||
            (i >= currentPage - 1 && i <= currentPage + 1)
        ) {
            paginationHtml += `<button onclick="changePage(${i})" ${
                i == currentPage ? 'class="active"' : ""
            }>${i}</button>`;
        } else if (i == currentPage - 2 || i == currentPage + 2) {
            paginationHtml += `<span>...</span>`;
        }
    }

    if (currentPage < totalPages) {
        paginationHtml += `<button onclick="changePage(${currentPage + 1})" ${
            currentPage == totalPages ? "disabled" : ""
        }>→</button>`;
    }

    const paginationElement = document.getElementById("pagination-button");
    if (paginationElement) {
        paginationElement.innerHTML = paginationHtml;
    }
}

function updateActiveButton(currentPage) {
    const buttons = document.querySelectorAll(".pagination-button button");
    // console.log(buttons);
    buttons.forEach((button, index) => {
        if (index + 1 == currentPage) {
            button.classList.add("active");
        } else {
            button.classList.remove("active");
        }
    });
}

function changePage(page) {
    let currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set("page", page);
    history.pushState(null, "", currentUrl);
    getScholarship();
}
document.addEventListener("DOMContentLoaded", function () {
    const currentPage = getQueryVariable("page") || 1;
    updateActiveButton(currentPage);
});

// update url without refresh
document.getElementById("itemsPerPage").addEventListener("change", function () {
    let currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set("page", 1);
    history.pushState(null, "", currentUrl);

    getScholarship();
});
// update url without refresh for search
document.addEventListener("DOMContentLoaded", function () {
    let searchElement = document.getElementById("search");

    if (searchElement) {
        searchElement.addEventListener("input", function () {
            let currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set("page", 1);
            history.pushState(null, "", currentUrl);

            debouncedSearch();
        });
    }
});

//check first
document.addEventListener("DOMContentLoaded", function () {
    let searchElement = document.getElementById("search");
    let rangeElement = document.getElementById("range");
    getScholarship();
    if (searchElement) {
        searchElement.addEventListener("input", debouncedSearch);
    }

    if (rangeElement) {
        rangeElement.addEventListener("input", debouncedSearch);
    }
});

function redirectToScholarships(uid, sid) {
    window.location.href = `/scholarships/${uid}/${sid}`;
}

function redirectToEditScholarship(uid, sid) {
    window.location.href = `/scholarships/edit?user_id=${uid}&scholarship_id=${sid}`;
}

var slider = document.getElementById("range");
var output = document.getElementById("coverage");
if (slider) {
    output.innerHTML = slider.value;

    slider.oninput = function () {
        output.innerHTML =
            "$" + this.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };
    const coverage = document.getElementById("coverage");
    const value = document.getElementById("range").value;
    coverage.innerHTML =
        "$" + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

var sortButton = document.getElementById("sortButton");
var arrow = document.getElementById("arrow");
var isClicked = false;
var isAscending;

sortButton.onclick = function () {
    if (!isClicked) {
        // Sort data in ascending order
        arrow.innerHTML = "↑";
        isClicked = true;
        isAscending = false;
    } else {
        if (arrow.innerHTML === "↑") {
            // Sort data in descending order
            arrow.innerHTML = "↓";
            isAscending = true;
        } else {
            // Sort data in ascending order
            arrow.innerHTML = "↑";
            isAscending = false;
        }
    }
    // console.log(isAscending);
    getScholarship("", isAscending ? "asc" : "desc");
};

const apply = (uis, sid) => {
    const formData = new FormData();
    formData.append("user_id_scholarship", uis);
    formData.append("scholarship_id", sid);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/scholarship/apply.php');

    xhr.onload = () => {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.status === 'success') {
                alert('Scholarship Applied');
            } else {
                alert('Failed to apply scholarship');
            }
        } else {
            alert('Failed to send the request. Server responded with status: ' + xhr.status);
        }
    };

    xhr.send(formData);

    return false; 
}

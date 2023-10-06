var alertModal = document.getElementById("alert-modal");
console.log(alertModal);

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

function renderPaginationBookmark(currentPage, totalItems, itemsPerPage) {
    // console.log(`Rendering Pagination: currentPage=${currentPage}, totalItems=${totalItems}, itemsPerPage=${itemsPerPage}`);
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    // console.log("totalItems:", totalItems);
    // console.log("itemsPerPage:", itemsPerPage);

    let paginationHtml = '';
    // console.log("TOTAL PAGE" , totalPages);
    for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `<button onclick="changePageBookmark(${i})">${i}</button>`;
    }

    const paginationElement = document.getElementById("pagination-button-bm");
    if (paginationElement) {
        paginationElement.innerHTML = paginationHtml;
        updateActiveButtonBookmark(currentPage);
    } 
}

function updateActiveButtonBookmark(currentPage) {
    // console.log("ADD ACTIVE BUTTON")
    const buttons = document.querySelectorAll(".pagination-button button");
    // console.log(buttons);
    buttons.forEach((button, index) => {
        if ((index + 1) == currentPage) {
            button.classList.add("active");
        } else {
            button.classList.remove("active");
        }
    });
}

function changePageBookmark(page) {
    let currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set("page", page);
    history.pushState(null, '', currentUrl);
    getBookmark();
}
document.addEventListener("DOMContentLoaded", function() {
    const currentPage = getQueryVariable("page") || 1;
    updateActiveButtonBookmark(currentPage);
});

// update url without refresh
document.getElementById("itemsPerPage").addEventListener('change', function() {
    let currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set("page", 1);
    history.pushState(null, '', currentUrl);
    
    getBookmark();
});
// update url without refresh for search
document.addEventListener("DOMContentLoaded", function() {
    let searchElement = document.getElementById("search");
    
    if(searchElement) { 
        searchElement.addEventListener('input', function() {
            let currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set("page", 1);
            history.pushState(null, '', currentUrl);

            debouncedSearch();
        });
    }
});

//check first
document.addEventListener("DOMContentLoaded", function() {
    let searchElement = document.getElementById("search");
    let rangeElement = document.getElementById("range");

    if(searchElement) {
        searchElement.addEventListener('input', debouncedSearch);
    }

    if(rangeElement) {
        rangeElement.addEventListener('input', debouncedSearch);
    }
});
function getBookmark(data="") {
    const titleElement = document.getElementById("search-bookmark");
    const coverageElement = document.getElementById("slide-bookmark");
    const itemsPerPageElement = document.getElementById("itemsPerPage");

    const title = titleElement ? titleElement.value : "";
    const coverage = coverageElement ? coverageElement.value : "";
    const itemsPerPage = itemsPerPageElement ? itemsPerPageElement.value : "";

    let base_url = "../../api/scholarship/viewBookmark.php";
    let add_url = "?judul=" + title + "&coverage=" + coverage + "&itemsPerPage=" + itemsPerPage;

    const page = getQueryVariable("page") || 1;
    add_url += "&page=" + page;

    const final_url = base_url + add_url;
    const xhr = new XMLHttpRequest();
    xhr.open("GET", final_url, true);
    xhr.onload = function () {
        if (this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (response.status !== 'error' && response.data && response.data.length > 0) {
                renderBookmarkedScholarships(response.data);
                // console.log("RENDER PAGINATION")
                renderPaginationBookmark(response.currentPage, response.total, itemsPerPage);
            } else {
                document.getElementById("bookmark-list").innerHTML = '<tr><td colspan="4">No bookmarked scholarships found.</td></tr>';
                document.getElementById("pagination-button-bm").innerHTML = '';
            }
        }
    }
    xhr.send();
}

function renderBookmarkedScholarships(bookmarkedScholarships) {
    const bookmarkedTableBody = document.getElementById('bookmark-list');
    bookmarkedTableBody.innerHTML = '';

    bookmarkedScholarships.forEach(scholarship => {
        let types = scholarship.types ? scholarship.types.join(', ') : 'N/A';
        let row = `
            <tr>
                <td>${scholarship.title}</td>
                <td>${scholarship.short_description}</td>
                <td>$${scholarship.coverage}</td>
                <td>${types}</td>
                <td>
                    <button onclick="deleteBookmark(${scholarship.user_id_scholarship}, ${scholarship.scholarship_id})">Remove Bookmark</button>
                    <button onclick="viewMore(${scholarship.user_id_scholarship},${scholarship.scholarship_id})">View More</button>
                </td>
            </tr>`;
        bookmarkedTableBody.innerHTML += row;
    });
}

const debounceBookmarkSearch = debounce(getBookmark, 300);
const searchBookmarkElement = document.getElementById("search-bookmark");
if(searchBookmarkElement) {
    searchBookmarkElement.addEventListener("input", debounceBookmarkSearch);
}

const itemsPerPageElement = document.getElementById('itemsPerPage');
if(itemsPerPageElement) {
    itemsPerPageElement.addEventListener('change', getBookmark);
}

const slideBookmarkElement = document.getElementById("slide-bookmark");
const coverageSpanElement = document.getElementById("coverage");
if (slideBookmarkElement && coverageSpanElement) {
    function updateCoverage() {
        const coverage = slideBookmarkElement.value;
        coverageSpanElement.textContent = coverage;
        getBookmark();
    }
    const debouncedUpdateCoverage = debounce(updateCoverage, 300);

    slideBookmarkElement.addEventListener("input", debouncedUpdateCoverage);
    updateCoverage();
}


getBookmark();

async function bookmark(userID, scholarshipID){
    const formData = new FormData();
    formData.append("uis", userID);
    formData.append("sid", scholarshipID);
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open('POST', '/api/scholarship/bookmark.php');
    xmlhttp.onload = () => {
        const res = JSON.parse(xmlhttp.response);
        if (res.status === 'success') {
            window.location.href = "/bookmarks";
        } else {
            alertModal.style.display = "block";
        }
    };
    xmlhttp.send(formData);
    return false;
}

function closeModal(){
    alertModal.style.display = "none";
}

async function deleteBookmark(userID, scholarshipID){
    const formData = new FormData();
    formData.append("uis", userID);
    formData.append("sid", scholarshipID);

    const xmr = new XMLHttpRequest();
    xmr.open("POST", "/api/scholarship/deleteBookmark.php");
    xmr.onload = () => {
        const response = JSON.parse(xmr.response);
        if(response.status === 'success'){
            window.location.href = "/bookmarks";
        }else{
            console.error(response.error);
        }
    };
    xmr.send(formData);
    return false;
}
 
//view more
function viewMore(uid, sid) {
    window.location.href = `/scholarships/${uid}/${sid}`;
}
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

const debouncedSearch = debounce(getReview, 300);

function renderReviews(response){
    let content = document.getElementById("content");
    content.innerHTML = '';
    if (response.status && response.status === 'error') {
        content.innerHTML = '<tr><td colspan="6">No Reviews found.</td></tr>';
    }else if(role == 'reviewer'){
        response.data.forEach(review => {
            action = "";

            if(review.type == 'pdf'){
                action = `<td><a class='file' href='/public/files/${review.link}' target='pdf'>${review.link}</a></td>`;
            }else if (review.type=='mp4'){
                action = `<td style='cursor: pointer;' onclick = 'openVideoModal("/public/files/${review.link}")'> ${review.link} </td>`;
            }

            let row=`
            <td>${review.user_id}</td>
            ${action}
            <td>${review.type}</td>
            <td>${review.review_status}</td>
            <td class="comment"><input type="text" value="${review.comment === null ? "" : review.comment}" id="comment-${review.user_id}-${review.file_id}" required></td>
            <td><button type='button' onclick='commentDocument("${review.user_id}","${review.file_id}")' data-toggle='modal' data-target='#exampleModalCenter'>Comment</button></td>`;         
            
            content.innerHTML += row;
        });
    }else{
        response.data.forEach(review => {
            action = "";

            if(review.type == 'pdf'){
                action = `<td><a class='file' href='/public/files/${review.link}' target='pdf'>${review.link}</a></td>`;
            }else if (review.type=='mp4'){
                action = `<td style='cursor: pointer;' onclick = 'openVideoModal("/public/files/${review.link}")'> ${review.link} </td>`;
            }

            let row=`
            <td>${review.file_id}</td>
            ${action}
            <td>${review.type}</td>
            <td>${review.review_status}</td>
            <td class="comment">${review.comment === null ? "" : review.comment} <br> -- <br> ${review.name} <br><i>${review.occupation}</i></td>
            <td><button type='button' onclick='submitDocument("${review.user_id}","${review.file_id}")' data-toggle='modal' data-target='#exampleModalCenter'>Daftarkan</button></td>`;         
            
            content.innerHTML += row;
        });
    }
}

function getReview(data="") {
    const status = document.getElementById("search").value;
    const itemsPerPage = document.getElementById("itemsPerPage").value;
    // console.log("CALLED");
    // console.log(title, coverage);

    let base_url = "../../api/review/search.php";
    let add_url = "";

    add_url += "?review_status=" + status;
    add_url += "&itemsPerPage=" + itemsPerPage;
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
            renderReviews(response);
        }
    }
    xhr.send();
}

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

document.addEventListener("DOMContentLoaded", function() {
    let searchElement = document.getElementById("search");

    if(searchElement) {
        searchElement.addEventListener('input', debouncedSearch);
    }
});

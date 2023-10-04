document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("search-form");
    const searchInput = document.getElementById("search");
    const scholarshipBody = document.querySelector(".scholarship-body tbody");
    const paginationForm = document.getElementById("pagination-form");

    searchForm.addEventListener("submit", function (e) {
        e.preventDefault();
        performSearch();
    });

    searchInput.addEventListener("input", function () {
        performSearch();
    });

    function performSearch() {
        const searchQuery = searchInput.value;
        fetch(`/scholarships/search?search=${searchQuery}`)
            .then((response) => response.text())
            .then((data) => {
                scholarshipBody.innerHTML = data;
                paginationForm.style.display = "none";
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
});

function redirectToScholarships(uid, sid) {
    // console.log(id);
    window.location.href = `/scholarships/${uid}/${sid}`;
}

var slider = document.getElementById("range");
var output = document.getElementById("coverage");
output.innerHTML = slider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function () {
    output.innerHTML = "$" + this.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};

const coverage = document.getElementById("coverage");
const value = document.getElementById("range").value;
coverage.innerHTML = "$" + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

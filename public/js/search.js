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
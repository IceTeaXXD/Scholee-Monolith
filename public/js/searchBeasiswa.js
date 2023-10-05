const searchBeasiswa = () => {
    let base_url = "../../api/beasiswa/search.php";
    let concat = "";
   
    try {
        const search = document.getElementById('search').value;
        if (search != "") {
            concat = "?search=" + search;
        }
        if (page.length > 0) {
            concat += "&page=" + page;
        } else {
            concat += "&page=1";
        }
    } catch (error) {
        console.log(error);
    }
    const xhr = new XMLHttpRequest();
    if (data != "") {
        final_url = base_url + data;
        concat = data;
    } else {
        final_url = base_url + concat;
    }
    xhr.open("GET", final_url, true);
    try {
        document.get
    }
}
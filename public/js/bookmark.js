var alertModal = document.getElementById("alert-modal");
console.log(alertModal);

async function bookmark(userID, scholarshipID){
    const formData = new FormData();
    formData.append("uis", userID);
    formData.append("sid", scholarshipID);
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open('POST', '/api/scholarship/bookmark.php');
    xmlhttp.onload = () => {
        const res = JSON.parse(xmlhttp.response);
        console.log("response");
        console.log(xmlhttp.response);
        if (res.status === 'success') {
            window.location.href = "/bookmarks";
        } else {
            alertModal.style.display = "block";
        }
    };
    console.log("sent")
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
        console.log("response");
        console.log(xmr.response);
        if(response.status === 'success'){
            window.location.href = "/bookmarks";
        }else{
            console.error(response.error);
        }
    };
    
    console.log("send");
    xmr.send(formData);
    return false;
}
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
            alert('Scholarship created successfully');
        } else {
            alert(res.error);
        }
    };
    console.log("sent")
    xmlhttp.send(formData);
    return false;
}
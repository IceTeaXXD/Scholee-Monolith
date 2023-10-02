var modal = document.getElementById("deleteModal");
var close = document.querySelector(".closebtn");
var userID, studentID;

function deleteConfirmation(uis, sid){
    modal.style.display = 'block';
    userID = uis;
    studentID = sid;
} 

async function confirmDelete(){
    /* DELETE */ 
    try {
        const formData = new FormData();
        formData.append('uid', userID);
        formData.append('sid', studentID);

        const response = await fetch('/api/scholarship/delete.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.status === 'success') {
            location.reload();
        }
    } catch (err) {
        console.log("There was an error:" + err);
    }

    modal.style.display = 'none';
}

function cancelDelete(){
    modal.style.display = 'none';
}

close.addEventListener('click', function() {
    modal.style.display = 'none';
});


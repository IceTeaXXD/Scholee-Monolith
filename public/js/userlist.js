const modal = document.getElementById("modal");
const userName = document.getElementById("modal-name");
var $userID = 0;

function deleteConfirmation($name, $uid){
    modal.style.display = "block";
    userName.innerHTML = $name;
    $userID = $uid;
}

function deleteUser(){
    const data = new FormData();
    data.append("user_id", $userID);

    const xmr = new XMLHttpRequest();
    xmr.open("POST", "/api/user/delete.php");
    xmr.send(data);
    xmr.onload = () => {
        const response = JSON.parse(xmr.responseText);
        console.log('Response:', response);

        if (response.status === 'success') {
            location.reload();
        } else {
            alert('Failed to delete user');
        }
    };
    return false;
}

function closeModal(){
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
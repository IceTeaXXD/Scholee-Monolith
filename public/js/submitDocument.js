var modal = document.getElementById("modal");
var vidSource = document.getElementById("videoSource");
var vidPlayer = document.getElementById("videoPlayer");
var closeModal = document.querySelector(".close");

function openVideoModal($url){
    modal.style.display = "block";
    vidSource.setAttribute("src", $url);
    vidPlayer.load();
}

closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
    vidPlayer.pause();
    vidSource.setAttribute('src', '');
});

function submitDocument(userId, fileId) {
    try {
        const formData = new FormData();
        formData.append('uid', userId);
        formData.append('fid', fileId);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/review/submit.php', true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data.status === 'success') {
                        location.reload();
                    }
                } else {
                    console.error("Request failed with status:", xhr.status);
                }
            }
        };

        xhr.send(formData);
    } catch (err) {
        console.error("There was an error:", err);
    }
}


function commentDocument(userId, fileId) {
    try {
        const commentInput = document.getElementById("comment-" + userId + "-" + fileId);

        if (!commentInput) {
            console.error("Comment input element not found.");
            return;
        }

        const commentValue = commentInput.value;

        const formData = new FormData();
        formData.append('uid', userId);
        formData.append('fid', fileId);
        formData.append('comment', commentValue);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/review/comment.php', true);

        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        console.error("Server returned an error:", data.error);
                    }
                } else {
                    console.error("Request failed with status:", xhr.status);
                }
            }
        };

        xhr.send(formData);
    } catch (err) {
        console.error("An error occurred:", err);
    }
}


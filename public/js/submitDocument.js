async function submitDocument(userId, fileId) {
    try {
        const formData = new FormData();
        formData.append('uid', userId);
        formData.append('fid', fileId);

        const response = await fetch('/api/review/submit.php', {
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
}

async function commentDocument(userId, fileId) {
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

        const response = await fetch('/api/review/comment.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            console.error("Request failed with status:", response.status);
            return;
        }

        const data = await response.json();

        if (data.status === 'success') {
            location.reload();
        } else {
            console.error("Server returned an error:", data.error);
        }
    } catch (err) {
        console.error("An error occurred:", err);
    }
}

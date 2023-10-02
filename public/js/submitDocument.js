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
var modal = document.getElementById('videoModal');
var videoPlayer = document.getElementById('videoPlayer');
var videoSource = document.getElementById('videoSource');

function openVideoModal(videoUrl) {
    videoSource.setAttribute('src', videoUrl);
    videoPlayer.load();
    modal.style.display = 'block';
}

var close = document.querySelector('.close');
close.addEventListener('click', function() {
    modal.style.display = 'none';
    videoPlayer.pause();
    videoSource.setAttribute('src', '');
});
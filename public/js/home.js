document.addEventListener("DOMContentLoaded", function() {
    var container = document.querySelector('.easy-steps-grid-container');
    var items = document.querySelectorAll('.easy-steps-grid-item');
    var startPos = 0;
    var endPos = 0;
    var autoScrollInterval;

    container.addEventListener('touchstart', function(e) {
        startPos = e.touches[0].clientX;
        stopAutoScroll(); // stop auto-scroll when user touches the container
    });

    container.addEventListener('touchend', function(e) {
        endPos = e.changedTouches[0].clientX;
        scrollOneItem();
        startAutoScroll(); // restart auto-scroll after user interaction
    });

    function scrollOneItem(direction = "left") {
        var slideWidth = items[0].getBoundingClientRect().width;
        var newScrollPosition;
        
        if (direction === "right" || endPos - startPos > 0) { // Swiped right
            newScrollPosition = container.scrollLeft - slideWidth;
        } else { // Swiped left
            newScrollPosition = container.scrollLeft + slideWidth;
        }

        container.scrollTo({
            left: newScrollPosition,
            behavior: 'smooth'
        });
    }

    function startAutoScroll() {
        // Scroll to the next item every 2 seconds
        autoScrollInterval = setInterval(function() {
            scrollOneItem();
        }, 2000);
    }

    function stopAutoScroll() {
        clearInterval(autoScrollInterval);
    }

    startAutoScroll(); // Start auto-scroll when the document is ready
});

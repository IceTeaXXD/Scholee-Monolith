const uploadCV = () => {
    window.location.href = "../../reviews/add";
}

const applyScholarship = () => {
    window.location.href = "../../scholarships"
}

const viewMoreClicked = (user_id, scholarship_id) => {
    window.location.href = "../../scholarships/" + user_id + "/" + scholarship_id;
}
let currentSlideIndex = 0;

function slideTo(index) {
    const list = document.querySelector('.scholarship-list');
    const item = list.querySelector('.scholarship-item');

    const style = window.getComputedStyle(item);
    const slideWidth = item.offsetWidth + (parseFloat(style.marginRight) || 0) + (parseFloat(style.marginLeft) || 0);
    
    list.style.transform = `translateX(${-index * slideWidth}px)`;
}

function nextSlide() {
    const list = document.querySelector('.scholarship-list');
    const totalSlides = list.childElementCount - 1; 
    
    currentSlideIndex = Math.min(currentSlideIndex + 1, totalSlides);
    slideTo(currentSlideIndex);
}

function prevSlide() {
    currentSlideIndex = Math.max(currentSlideIndex - 1, 0);
    slideTo(currentSlideIndex);
}
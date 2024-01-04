var swiper = new Swiper('.story', {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: false,
    pagination: {
        clickable: true,
    },
    autoplay: {
      delay: 8000,
  },
    navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
})

document.addEventListener('DOMContentLoaded', function () {
    var openButtons = document.querySelectorAll('.show-cogStory');
    openButtons.forEach(function (button) {
        button.addEventListener('click', function () {
          console.log('click');
            var storyId = button.getAttribute('data-story-id');
            var deleteContainer = document.getElementById('delete-container-' + storyId);
            deleteContainer.classList.toggle('hidden');
        });
    });
});

var memberListItems = document.querySelectorAll('.storier');
memberListItems.forEach(function (item) {
    item.addEventListener('click', function () {
        var slideIndex = parseInt(this.getAttribute('data-slide-index'), 10);
        swiper.slideTo(slideIndex);
    });
});

const modalStory = document.getElementById("modal-story")
const deletePreviewStory = document.getElementById("delete-preview-story")
function previewStory(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imageStory = document.getElementById("previewStory");
            imageStory.src = e.target.result;
            modalStory.classList.remove("hidden");
        };
        reader.readAsDataURL(input.files[0]);
    }
}
deletePreviewStory.addEventListener("click", function () {
    const imageStory = document.getElementById("previewStory");
    imageStory.src = "";
    modalStory.classList.add("hidden");
});

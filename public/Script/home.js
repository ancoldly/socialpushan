var swiper = new Swiper('.story-swiper', {
    slidesPerView: 5,
    spaceBetween: 10,
    loop: false,
    pagination: {
        clickable: true,
    },
    navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
})

const showToolsProfile = document.querySelector(".show-tools-profile");
const toolsProfile = document.querySelector(".tools-profile");

showToolsProfile.addEventListener("click", function () {
    toggleVisibility(this, toolsProfile);
});

const showToolsMessage = document.querySelector(".show-tools-message");
const toolsMessage = document.querySelector(".tools-message");

showToolsMessage.addEventListener("click", function () {
    toggleVisibility(this, toolsMessage);
});

const showToolsTell = document.querySelector(".show-tools-tell");
const toolsTell = document.querySelector(".tools-tell");

showToolsTell.addEventListener("click", function () {
    toggleVisibility(this, toolsTell);
});

function toggleVisibility(clickedElement, targetElement) {
    const allTargets = document.querySelectorAll(".tools-profile, .tools-message, .tools-tell");

    allTargets.forEach((element) => {
        if (element !== targetElement) {
            element.classList.remove("grid");
            element.classList.add("hidden");
        }
    });

    targetElement.classList.toggle("hidden");
    targetElement.classList.toggle("grid");
}




const deleteButtons = document.querySelectorAll(".delete-imageEditPost-preview");

deleteButtons.forEach(function (deleteButton) {
  deleteButton.addEventListener("click", function () {
    const postId = this.getAttribute("data-post-id");
    const imagePreview = document.getElementById(`imageEditPost-preview-${postId}`);
    const imageInput = document.getElementById(`imageEdit-post-${postId}`);
    const currentImageInput = document.getElementById(`current-image-${postId}`);

    imagePreview.src = "";
    imageInput.value = "";
    currentImageInput.value = "";
    this.classList.add("hidden");

    const contentEditPost = document.querySelector(`#editPost-form[data-post-id="${postId}"] textarea[name="edit-post"]`);
    const editPostButton = document.querySelector(`#editPost-form[data-post-id="${postId}"] button[name="submit-edit-post"]`);

    if (contentEditPost.value.trim() !== "") {
      editPostButton.disabled = false;
      editPostButton.classList.remove("cursor-no-drop");
      editPostButton.classList.add("bg-blue-300");
      editPostButton.classList.remove("bg-gray-200");
    } else {
      editPostButton.disabled = true;
      editPostButton.classList.add("cursor-no-drop");
      editPostButton.classList.remove("bg-blue-300");
      editPostButton.classList.add("bg-gray-200");
    }
  });
});

const cogPosts = document.querySelectorAll(".cogPost");
const showCogPosts = document.querySelectorAll(".show-cogPost");
const editPostForms = document.querySelectorAll(".editPost-show");

showCogPosts.forEach((showCogPost, index) => {
    showCogPost.addEventListener("click", function () {
        const postId = this.getAttribute("data-post-id");

        cogPosts.forEach((cogPost) => {
            const post = cogPost.getAttribute("data-post-id");

            if (post === postId) {
                cogPost.classList.toggle("hidden");
                cogPost.classList.toggle("grid");

                if (cogPost.classList.contains("hidden")) {
                    const editPostForm =
                        cogPost.querySelector(".editPost-show");
                    editPostForm.classList.add("hidden");
                    editPostForm.classList.remove("grid");
                }
            }
        });
    });
});

const editPostButtons = document.querySelectorAll(".editPost");

editPostButtons.forEach(function (button, index) {
    button.addEventListener("click", function () {
        editPostForms[index].classList.toggle("hidden");
        editPostForms[index].classList.toggle("grid");
    });
});

const showCogComments = document.querySelectorAll(".show-cogComments"); //
const cogComments = document.querySelectorAll(".cogComments");
let activeCogComment = null;

showCogComments.forEach((showCogComment) => {
    showCogComment.addEventListener("click", function () {
        const commentId = showCogComment.getAttribute("data-id-comments");
        const cogComment = document.querySelector(
            `.cogComments[data-id-comments="${commentId}"]`
        );

        if (activeCogComment && activeCogComment !== cogComment) {
            activeCogComment.classList.add("hidden");
            activeCogComment.classList.remove("grid");
        }

        cogComment.classList.toggle("hidden");
        cogComment.classList.toggle("grid");

        activeCogComment = cogComment;
    });
});

const editCommentsButtons = document.querySelectorAll(
    ".show-form-EditComments"
);
let currentFormEditComments = null;

editCommentsButtons.forEach(function (editCommentsButton) {
    editCommentsButton.addEventListener("click", function () {
        const postId = editCommentsButton.dataset.editId;
        const commentId = editCommentsButton.dataset.idComments;
        const formEditComments = document.querySelector(
            `form[data-edit-id="${postId}"][data-id-comments="${commentId}"]`
        );

        const isFormVisible = formEditComments.classList.contains("flex");

        if (isFormVisible) {
            formEditComments.classList.remove("flex");
            formEditComments.classList.add("hidden");
            currentFormEditComments = null;
        } else {
            if (currentFormEditComments) {
                currentFormEditComments.classList.remove("flex");
                currentFormEditComments.classList.add("hidden");
            }

            formEditComments.classList.remove("hidden");
            formEditComments.classList.add("flex");

            currentFormEditComments = formEditComments;
        }
    });
});

const cancel_editComment = document.querySelectorAll('.cancel-editComment');

cancel_editComment.forEach(function(cancelButton) {
    cancelButton.addEventListener("click", function() {
        location.reload();
    });
});

const cancel_editPost = document.querySelectorAll('.cancel-editPost');

cancel_editPost.forEach(function(cancelButton) {
    cancelButton.addEventListener("click", function() {
        location.reload();
    });
});

function previewAvatar(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imagePostPreview = document.getElementById("avatar-preview");
            imagePostPreview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

const delete_imagePost_preview = document.querySelector(
    ".delete-imagePost-preview"
);

delete_imagePost_preview.addEventListener("click", function () {
    const imagePostInput = document.getElementById("image-post");
    const imagePostPreview = document.getElementById("imagePost-preview");
    imagePostPreview.src = "";

    if (imagePostInput) {
        imagePostInput.value = "";
    }

    delete_imagePost_preview.classList.add("hidden");
});

function previewImagePost(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imagePostPreview =
                document.getElementById("imagePost-preview");
            imagePostPreview.src = e.target.result;
            delete_imagePost_preview.classList.remove("hidden");
        };
        reader.readAsDataURL(input.files[0]);
    }
}

delete_imagePost_preview.addEventListener("click", function () {
    const avatarPreview = document.getElementById("imagePost-preview");
    avatarPreview.src = "";
    var contentPost = document.getElementById('content-post');
    var createPostButton = document.querySelector('#createPost-form button[name="submit-create-post"]');
    if (contentPost.value.trim() !== "") {
        createPostButton.disabled = false;
        createPostButton.classList.remove('cursor-no-drop');
        createPostButton.classList.add('bg-blue-200');
        createPostButton.classList.remove('bg-gray-200');
    } else {
        createPostButton.disabled = true;
        createPostButton.classList.add('cursor-no-drop');
        createPostButton.classList.remove('bg-blue-200');
        createPostButton.classList.add('bg-gray-200');
    }

    delete_imagePost_preview.classList.add("hidden");
});

function previewImageEditPost(event, postId) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imagePreview = document.getElementById(
                `imageEditPost-preview-${postId}`
            );
            imagePreview.src = e.target.result;
            const deleteButton = document.querySelector(
                `.delete-imageEditPost-preview[data-post-id="${postId}"]`
            );
            if (deleteButton) {
                deleteButton.classList.remove("hidden");
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

const images = document.querySelectorAll(".imageEditPost-preview");

images.forEach((image) => {
    const postId = image.getAttribute("data-post-id");
    const srcValue = image.getAttribute("src");
    const deleteButton = document.getElementById(
        `delete-imageEditPost-preview-${postId}`
    );

    if (srcValue === "") {
        deleteButton.classList.add("hidden");
    }
});

var contentPost = document.getElementById('content-post');
var imagePost = document.getElementById('image-post');
var createPostButton = document.querySelector('#createPost-form button[name="submit-create-post"]');

function checkInput() {
    var content = contentPost.value.trim();
    var image = imagePost.value;

    if (content !== "" || image !== "") {
        createPostButton.disabled = false;
        createPostButton.classList.remove('cursor-no-drop');
        createPostButton.classList.remove('bg-gray-200');
        createPostButton.classList.add('bg-blue-200');
    } else {
        createPostButton.disabled = true;
        createPostButton.classList.add('cursor-no-drop');
        createPostButton.classList.add('bg-gray-200');
        createPostButton.classList.remove('bg-blue-200');
    }
}

contentPost.addEventListener('input', checkInput);
imagePost.addEventListener('change', checkInput);

var editPostForm = document.querySelectorAll("#editPost-form");

editPostForm.forEach(function (form) {
    var postId = form.getAttribute("data-post-id");
    var contentEditPost = form.querySelector('textarea[name="edit-post"]');
    var imageEditPost = form.querySelector('input[name="imageEdit-post"]');
    var currentImageInput = form.querySelector('input[name="current-image"]');
    var editPostButton = form.querySelector('button[name="submit-edit-post"]');

    contentEditPost.addEventListener("input", function () {
        checkInputEdit(postId);
    });

    imageEditPost.addEventListener("change", function () {
        checkInputEdit(postId);
    });

    function checkInputEdit(postId) {
        var content = contentEditPost.value.trim();
        var currentImage = currentImageInput.value.trim();

        var newImage =
            imageEditPost.files.length > 0 ? imageEditPost.files[0].name : "";

        if (content == "" && currentImage == "" && newImage == "") {
            editPostButton.disabled = true;
            editPostButton.classList.add("cursor-no-drop");
            editPostButton.classList.add("bg-gray-200");
            editPostButton.classList.remove("bg-blue-300");
        } else {
            editPostButton.disabled = false;
            editPostButton.classList.remove("cursor-no-drop");
            editPostButton.classList.remove("bg-gray-200");
            editPostButton.classList.add("bg-blue-300");
        }
    }
});

var editCommentForm = document.querySelectorAll('#editComment-form');

editCommentForm.forEach(function(form) {
    var commentId = form.getAttribute('data-id-comments');
    var contentEditComment = form.querySelector('textarea[name="Editcomments"]');
    var editCommentButton = form.querySelector('button[name="submitEdit-comments"]');

    contentEditComment.addEventListener('input', function() {
        checkInputEdit(commentId);
    });

    function checkInputEdit(commentId) {
        var content = contentEditComment.value.trim();

        if (content === "") {
            editCommentButton.disabled = true;
            editCommentButton.classList.add('cursor-no-drop');
        } else {
            editCommentButton.disabled = false;
            editCommentButton.classList.remove('cursor-no-drop');
        }
    }
});

function previewAvatarGroup(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imagePostPreview = document.getElementById("previewAvatarGroup");
            imagePostPreview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('imageGroup').addEventListener('change', function(event) {
    previewAvatarGroup(event);
});

function previewAvatarGroupEdit(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imagePostPreview = document.getElementById(
                "previewAvatarGroupEdit"
            );
            imagePostPreview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document
    .getElementById("imageGroupEdit")
    .addEventListener("change", function (event) {
        previewAvatarGroupEdit(event);
    });

const cancel_editGroupChat = document.querySelectorAll(
    ".cancel-editGroupChat"
);

cancel_editGroupChat.forEach(function (cancelBtn) {
    cancelBtn.addEventListener("click", function () {
        document
            .getElementById("form-editGroupChat")
            .classList.add("hidden");
        document
            .getElementById("form-editGroupChat")
            .classList.remove("grid");
    });
});

window.addEventListener("click", function (event) {
    const formEditGroupChat =
        document.getElementById("form-editGroupChat");

    if (!formEditGroupChat.contains(event.target)) {
        formEditGroupChat.classList.add("hidden");
        formEditGroupChat.classList.remove("grid");
    }
});

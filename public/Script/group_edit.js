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

const cancel_editGroup = document.querySelectorAll(
    ".cancel-editGroup"
);

cancel_editGroup.forEach(function (cancelBtn) {
    cancelBtn.addEventListener("click", function () {
        document
            .getElementById("form-editGroup")
            .classList.add("hidden");
        document
            .getElementById("form-editGroup")
            .classList.remove("grid");
    });
});

window.addEventListener("click", function (event) {
    const formEditGroup =
        document.getElementById("form-editGroup");

    if (!formEditGroup.contains(event.target)) {
        formEditGroup.classList.add("hidden");
        formEditGroup.classList.remove("grid");
    }
});

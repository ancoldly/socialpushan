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

const show_tools_profile = document.querySelector(".show-tools-profile");
const tools_profile = document.querySelector(".tools-profile");

show_tools_profile.addEventListener("click", function () {
    if (tools_message.classList.contains("grid")) {
        tools_message.classList.remove("grid");
        tools_message.classList.add("hidden");
    }

    tools_profile.classList.toggle("hidden");
    tools_profile.classList.toggle("grid");
});

const show_tools_message = document.querySelector(".show-tools-message");
const tools_message = document.querySelector(".tools-message");

show_tools_message.addEventListener("click", function () {
    if (tools_profile.classList.contains("grid")) {
        tools_profile.classList.remove("grid");
        tools_profile.classList.add("hidden");
    }

    tools_message.classList.toggle("hidden");
    tools_message.classList.toggle("grid");
});

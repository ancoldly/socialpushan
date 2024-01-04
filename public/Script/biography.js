const edit_biography = document.querySelector(".edit-biography");
const btn_edit_biography = document.querySelector(".btn-biography");
const cancel_biography = document.querySelector(".cancel-biography");

btn_edit_biography.addEventListener("click", function () {
    edit_biography.classList.remove("hidden");
});

cancel_biography.addEventListener("click", function () {
    location.reload();
});

const textarea = document.getElementById("biography");
const charCount = document.getElementById("char-count");
const maxLength = 101;

textarea.addEventListener("input", function () {
    const currentChars = textarea.value.length;
    const remainingChars = maxLength - currentChars;

    charCount.textContent = "Characters left: " + remainingChars;

    if (remainingChars < 0) {
        textarea.value = textarea.value.slice(0, maxLength);
        charCount.textContent = "Character limit exceeded!";
    }
});

const currentChars = textarea.value.length;
const remainingChars = maxLength - currentChars;
charCount.textContent = "Characters left: " + remainingChars;

const messageSend = document.getElementById('send');
    const messageInput = document.getElementById('message');

    messageSend.addEventListener("click", function() {
        messageInput.value = '';
    });

function previewAvatarGroup(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imageGroup = document.getElementById("AvatarGroup");
            const demoAvatarGroup = document.getElementById("DemoAvatarGroup");
            imageGroup.src = e.target.result;
            demoAvatarGroup.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('imageGroup').addEventListener('change', function(event) {
    previewAvatarGroup(event);
});


document.addEventListener('DOMContentLoaded', function() {
    const nameGroupInput = document.querySelector('input[name="nameGroup"]');
    const demoNameGroup = document.getElementById('demoNameGroup');

    nameGroupInput.addEventListener('input', handleNameInputChange);

    function handleNameInputChange(event) {
        const inputValue = event.target.value;

        const groupName = inputValue.trim() !== '' ? inputValue : 'Group name';

        demoNameGroup.textContent = groupName;
    }
});


const nameGroupInput = document.querySelector('input[name="nameGroup"]');
const imageGroupInput = document.getElementById('imageGroup');
const createButton = document.getElementById('createButton');

nameGroupInput.addEventListener('input', handleInputChange);
imageGroupInput.addEventListener('input', handleInputChange);

function handleInputChange() {
    const nameGroupValue = nameGroupInput.value.trim();
    const imageGroupValue = imageGroupInput.value.trim();

    if (nameGroupValue === '' || imageGroupValue === '') {
        createButton.disabled = true;
        createButton.classList.add('cursor-no-drop');
    } else {
        createButton.disabled = false;
        createButton.classList.remove('cursor-no-drop');
    }
}


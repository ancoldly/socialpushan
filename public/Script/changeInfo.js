function enableEdit(editButton, inputField) {
  editButton.addEventListener("click", function () {
    inputField.removeAttribute("readonly");
    inputField.classList.add("text-red-500");
  });
}

const edituserName = document.querySelector(".edit-username");
const inputuserName = document.querySelector(".ip-userName");
enableEdit(edituserName, inputuserName);

const edittelePhone = document.querySelector(".edit-telePhone");
const inputtelePhone = document.querySelector(".ip-telePhone");
enableEdit(edittelePhone, inputtelePhone);

const editbirthDate = document.querySelector(".edit-birthDate");
const inputbirthDate = document.querySelector(".ip-birthDate");
enableEdit(editbirthDate, inputbirthDate);

const editGender = document.querySelector(".edit-Gender");
const inputGender = document.querySelector(".ip-Gender");
enableEdit(editGender, inputGender);

const editaddress = document.querySelector(".edit-address");
const inputaddress = document.querySelector(".ip-address");
enableEdit(editaddress, inputaddress);

const editGenderButton = document.querySelector(".edit-Gender");
const genderSelect = document.querySelector("#gender");
const selectedGenderInput = document.querySelector("#selected-gender");

editGenderButton.addEventListener("click", function () {
  genderSelect.disabled = false;
});

genderSelect.addEventListener("change", function () {
  selectedGenderInput.value =
    genderSelect.options[genderSelect.selectedIndex].text;
});

const saveInfomation = document.querySelector('.save-infomation');

inputuserName.addEventListener("input", function () {
    if (this.value.trim() === "") {
        document.querySelector('#err').textContent = 'Name cannot be empty.';
        saveInfomation.setAttribute('disabled', 'true');
        saveInfomation.classList.add('cursor-no-drop');
    } else {
        document.querySelector('#err').textContent = 'Valid name.';
        saveInfomation.removeAttribute('disabled');
        saveInfomation.classList.remove('cursor-no-drop');
    }
});

function calculateAge(birthdate) {
    const birthDate = new Date(birthdate);

    const currentDate = new Date();

    let age = currentDate.getFullYear() - birthDate.getFullYear();

    if (
        currentDate.getMonth() < birthDate.getMonth() ||
        (currentDate.getMonth() === birthDate.getMonth() &&
            currentDate.getDate() < birthDate.getDate())
    ) {
        age--;
    }

    return age;
}

const birthdateInput = document.querySelector(".ip-birthDate");

birthdateInput.addEventListener("input", function () {
    const age = calculateAge(this.value);

    if (age < 14) {
        document.querySelector('#err').textContent = 'You must be 14 years or older.';
        saveInfomation.setAttribute('disabled', 'true');
        saveInfomation.classList.add('cursor-no-drop');
    } else {
        document.querySelector('#err').textContent = 'Valid age.';
        saveInfomation.removeAttribute('disabled');
        saveInfomation.classList.remove('cursor-no-drop');
    }
});

const currentPassword = document.querySelector('#currentPassword');

const newPassword = document.querySelector('#newPassword');

const confirmPassword = document.querySelector('#confirmPassword');

const editPassword = document.querySelector('.submit-editPassword');

if (
    currentPassword.value.trim() === '' ||
    newPassword.value.trim() === '' ||
    confirmPassword.value.trim() === ''
) {
    editPassword.setAttribute('disabled', true);
    editPassword.classList.add('cursor-no-drop');
}

function checkEmptyFields() {
    if (
        currentPassword.value.trim() === '' ||
        newPassword.value.trim() === '' ||
        confirmPassword.value.trim() === ''
    ) {
        editPassword.setAttribute('disabled', true);
        editPassword.classList.add('cursor-no-drop');
    } else {
        editPassword.removeAttribute('disabled');
        editPassword.classList.remove('cursor-no-drop');
    }

    if(currentPassword.value.trim() !== '')
    {
        if(newPassword.value.length > 0 && newPassword.value.length < 6) {
            document.querySelector('#err-password').textContent = 'Password must have more than 6 characters.';
        } else {
            if(confirmPassword.value !== newPassword.value) {
                document.querySelector('#err-password').textContent = 'New password does not match. Please re-enter the new password.';
            } else {
                document.querySelector('#err-password').textContent = '';
            }
        }
    } else {
        document.querySelector('#err-password').textContent = '';
    }
}

currentPassword.addEventListener('input', checkEmptyFields);
newPassword.addEventListener('input', checkEmptyFields);
confirmPassword.addEventListener('input', checkEmptyFields);

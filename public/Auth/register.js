const genderSelect = document.getElementById('gender');
const genderInput = document.querySelector('.gender');

genderSelect.addEventListener('change', function() {
  genderInput.value = genderSelect.options[genderSelect.selectedIndex].text;
});

const showpass = document.querySelector('.bx-low-vision');
const ip_pass = document.querySelector('.password');

showpass.addEventListener('click', function() {
    if (ip_pass.type === 'password') {
        ip_pass.type = 'text';
    } else {
        ip_pass.type = 'password';
    }
});

let registerLayout = document.querySelector("#register-layout");
let showRegisterWindowBtn = document.querySelector("#show-register-window-btn");

showRegisterWindowBtn.addEventListener("click", showRegisterWindow);
registerLayout.addEventListener("click", function (ev) {
    if (ev.target === this) exitRegisterWindow();
});

function showRegisterWindow(){
    registerLayout.classList.remove("d-none");
}
function exitRegisterWindow(){
    registerLayout.classList.add("d-none");
}



const form = document.getElementById('registration-form');

form.addEventListener('submit', handleRegistration);

async function handleRegistration(event) {
    event.preventDefault();

    const nameInput = document.getElementById('register-name');
    const familyNameInput = document.getElementById('register-familyName');
    const emailInput = document.getElementById('register-email');
    const passwordInput = document.getElementById('register-password');
    const confirmPasswordInput = document.getElementById('register-confirmPassword');


    // --- Client-side validation ---
    const name = nameInput.value.trim();
    const familyName = familyNameInput.value.trim();
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
    const confirmPassword = confirmPasswordInput.value.trim();

    if (!name || !familyName || !email || !password) {
        alert('All fields are required.');
        return;
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return;
    }


    //errorMessageDiv.classList.add('d-none');
    const requestBody = {
        name: name,
        familyName: familyName,
        email: email,
        password: password
    };

    try {
        const response = await fetch('/profile/registerAsync', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestBody)
        });

        const result = await response.json();

        if (response.ok) {
            window.location.replace(window.location.href);
        } else {
            alert(result.message || 'An unknown error occurred.');
        }
    } catch (error) {
        console.error('Registration failed:', error);
        alert('A network error occurred. Please try again.');
    }
}
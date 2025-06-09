
const form = document.getElementById('profile-form');

const saveBtn = document.getElementById('save-profile-btn');
const successMessageDiv = document.getElementById('success-message');
const errorMessageDiv = document.getElementById('error-message');

form.addEventListener('submit', handleProfileUpdate);

async function handleProfileUpdate(event) {
    event.preventDefault();

    // Hide previous messages
    successMessageDiv.classList.add('d-none');
    errorMessageDiv.classList.add('d-none');

    // Get form inputs
    const nameInput = document.getElementById('name');
    const familyNameInput = document.getElementById('familyName');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const mailIndexInput = document.getElementById('mailIndex');
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');

    const newPassword = newPasswordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    // --- Client-side validation for password ---
    if (newPassword && newPassword !== confirmPassword) {
        showError('New passwords do not match.');
        return;
    }

    // --- Build request body with only the fields to be updated ---
    const requestBody = {};

    // Add fields that have a value
    if (nameInput.value.trim()) requestBody.name = nameInput.value.trim();
    if (familyNameInput.value.trim()) requestBody.familyName = familyNameInput.value.trim();
    if (emailInput.value.trim()) requestBody.email = emailInput.value.trim();

    // Optional fields can be sent even if empty to clear them
    requestBody.phone = phoneInput.value.trim();
    requestBody.mailIndex = mailIndexInput.value.trim();

    if (newPassword) {
        requestBody.password = newPassword;
    }

    // --- API Call ---
    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving...';

    try {
        const response = await fetch('/profile/updateAsync', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestBody)
        });

        const result = await response.json();

        if (response.ok) {
            showSuccess(result.message || 'Profile updated successfully!');
            // Clear password fields on success
            newPasswordInput.value = '';
            confirmPasswordInput.value = '';
        } else {
            showError(result.message || 'An unknown error occurred.');
        }
    } catch (error) {
        console.error('Profile update failed:', error);
        showError('A network error occurred. Please try again.');
    } finally {
        saveBtn.disabled = false;
        saveBtn.textContent = 'Save Changes';
    }
}

function showMessage(element, message) {
    element.textContent = message;
    element.classList.remove('d-none');
    window.scrollTo(0, 0); // Scroll to top to make message visible
}

function showSuccess(message) {
    showMessage(successMessageDiv, message);
}

function showError(message) {
    showMessage(errorMessageDiv, message);
}

let loginLayout = document.getElementById("login-layout");
let emailInput = document.querySelector("input#email");
let passwordInput = document.querySelector("input#password");


let exitLoginWindowBtn = document.querySelector("#exit-login-window-btn");
let confirmLoginActionBtn = document.querySelector("#confirm-login-action-btn");
let showLoginWindowBtn = document.querySelector("#show-login-window-btn");


showLoginWindowBtn.addEventListener("click", function (ev) {
    loginLayout.classList.remove("d-none");
});

exitLoginWindowBtn.addEventListener("click", function (ev) {
    loginLayout.classList.add("d-none");
});

confirmLoginActionBtn.addEventListener("click", async function (ev) {
    let email = emailInput.value.trim();
    let password = passwordInput.value.trim();

    let requestBody = {
        "email" : email,
        "password" : password
    };

    let response = await fetch("/profile/login", {method : "POST", headers: {'Content-Type': 'application/json'},  body : JSON.stringify(requestBody)});
    let responseData = await response.json();


    let status = responseData['status'];
    let message = responseData['message'];

    if (status === '200'){
        document.location.replace(currentLocation);
    } else  {
        alert(message);
    }
});

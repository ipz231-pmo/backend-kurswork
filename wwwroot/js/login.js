let loginLayout = document.getElementById("login-layout");
let emailInput = document.querySelector("input#email");
let passwordInput = document.querySelector("input#password");


let exitLoginWindowBtn = document.querySelector("#exit-login-window-btn");
let confirmLoginActionBtn = document.querySelector("#confirm-login-action-btn");
let showLoginWindowBtn = document.querySelector("#show-login-window-btn");


showLoginWindowBtn.addEventListener("click", showLoginWindow);
exitLoginWindowBtn.addEventListener("click", exitLoginWindow);
confirmLoginActionBtn.addEventListener("click", confirmLoginAction);


function showLoginWindow(){
    window.scrollTo(0,0);
    loginLayout.classList.remove("d-none");
}
function exitLoginWindow(){
    loginLayout.classList.add("d-none");
}
async function confirmLoginAction(){
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
        document.location.replace(document.location.href);
    } else  {
        alert(message);
    }
}

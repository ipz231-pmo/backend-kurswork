let logoutLayout = document.getElementById("logout-layout");

let exitLogoutWindowBtn = document.querySelector("#exit-logout-window-btn");
let confirmLogoutActionBtn = document.querySelector("#confirm-logout-action-btn");
let showLogoutWindowBtn = document.querySelector("#show-logout-window-btn");

showLogoutWindowBtn.addEventListener("click", showLogoutWindow);
exitLogoutWindowBtn.addEventListener("click", exitLogoutWindow);
confirmLogoutActionBtn.addEventListener("click", confirmLogoutAction);

function showLogoutWindow() {
    logoutLayout.classList.remove("d-none");
}
function exitLogoutWindow() {
    logoutLayout.classList.add("d-none");
}
async function confirmLogoutAction() {
    let response = await fetch("/profile/logout", {method : "POST"})
    let responseData = await response.json();
    if(responseData['status'] === '200'){
        document.location.replace("/");
    } else {
        alert(`Failed to logout: ${responseData['message']}`);
    }
}

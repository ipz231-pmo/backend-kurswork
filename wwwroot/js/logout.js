let logoutLayout = document.getElementById("logout-layout");


let exitLogoutWindowBtn = document.querySelector("#exit-logout-window-btn");
let confirmLogoutActionBtn = document.querySelector("#confirm-logout-action-btn");
let showLogoutWindowBtn = document.querySelector("#show-logout-window-btn");

showLogoutWindowBtn.addEventListener("click", function (ev) {
    logoutLayout.classList.remove("d-none");
});

exitLogoutWindowBtn.addEventListener("click", function (ev) {
    logoutLayout.classList.add("d-none");
});


confirmLogoutActionBtn.addEventListener("click", async function (ev) {
    let response = await fetch("/profile/logout", {method : "POST"})
    let responseData = await response.json();
    if(responseData['status'] === '200'){
        document.location.replace("/");
    } else {
        alert(`Failed to logout: ${responseData['message']}`);
    }

});

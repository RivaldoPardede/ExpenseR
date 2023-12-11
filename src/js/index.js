const signIn_form = document.getElementById("signIn-form");
const signUp_form = document.getElementById("signUp-form");
const signIn_link = document.getElementById("signIn-link");
const signUp_link = document.getElementById("signUp-link");

signUp_link.addEventListener("click", () => {
    signIn_form.classList.add("hidden");
    signUp_form.classList.remove("hidden");
});

signIn_link.addEventListener("click", () => {
    signIn_form.classList.remove("hidden");
    signUp_form.classList.add("hidden");
});

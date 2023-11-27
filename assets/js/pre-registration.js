function validateEmail() {
    const emailInput = document.getElementById("email");
    const emailError = document.getElementById("emailError");

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValidEmail = emailPattern.test(emailInput.value);

    if (!isValidEmail) {
        emailError.classList.remove("hidden");
    } else {
        emailError.classList.add("hidden");
    }
}

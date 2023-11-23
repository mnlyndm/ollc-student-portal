function generateStudentIdAndPwd() {

    var courseIframe = document.getElementById('courseIframe');
    var selectedCourse = courseIframe.contentWindow.document.getElementById('course').value;

    if (!selectedCourse) {
        alert("Please select a course before submitting the form.");
        return;
    }

    var requiredFields = document.querySelectorAll('input[required]');
    for (var i = 0; i < requiredFields.length; i++) {
        if (!requiredFields[i].value) {
            alert("Please fill out all required fields before submitting the form.");
            return;
        }
    }

    if (document.getElementById('submit').disabled) {
        alert("You have already submitted the form.");
        return;
    }     

    var stdSurname = document.getElementById('stdSurname').value;
    var stdFirstname = document.getElementById('stdFirstname').value;

    document.getElementById('submit').disabled = true;

    var currentDate = new Date();
    var studentId =
        currentDate.getFullYear().toString().substr(-2) +
        ('0' + (currentDate.getMonth() + 1)).slice(-2) +
        ('0' + currentDate.getDate()).slice(-2) +
        ('0' + currentDate.getHours()).slice(-2) +
        ('0' + currentDate.getMinutes()).slice(-2) +
        ('0' + currentDate.getSeconds()).slice(-2) +
        getAlphabetPosition(stdFirstname.charAt(0)) +
        getAlphabetPosition(stdSurname.charAt(0));

    var password = generateRandomPassword(8);

    document.getElementById('generatedStdID').innerText = studentId;
    document.getElementById('generatedPwd').innerText = password;

    var blob = new Blob(["Student ID: " + studentId + "\nPassword: " + password], { type: "text/plain" });

    var a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = studentId + ".txt";
        a.click();

        document.getElementById('popup').style.display = 'block';
}

function btnPopup() {
    window.location.href = '../student/login.html';
}

function getAlphabetPosition(letter) {
    return letter.toUpperCase().charCodeAt(0) - 64;
}

function generateRandomPassword(length) {
    var charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    var password = "";
    for (var i = 0; i < length; i++) {
        var randomIndex = Math.floor(Math.random() * charset.length);
        password += charset.charAt(randomIndex);
    }
    return password;
}
function validateEmail() {
    var emailInput = document.getElementById("email");
    var emailError = document.getElementById("emailError");

    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var isValidEmail = emailPattern.test(emailInput.value);

    if (!isValidEmail) {
        emailError.classList.remove("hidden");
    } else {
        emailError.classList.add("hidden");
    }
}
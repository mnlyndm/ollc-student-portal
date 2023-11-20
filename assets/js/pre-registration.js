function generateStudentIdAndPwd() {

    var stdSurname = document.getElementById('stdSurname').value;
    var stdFirstname = document.getElementById('stdFirstname').value;

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

    document.getElementById('generatedStdID').innerText = "Generated Student ID: " + studentId;
    document.getElementById('generatedPwd').innerText = "Generated Password: " + password;

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
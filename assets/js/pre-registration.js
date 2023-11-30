function validateEmail() {
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    emailError.classList.toggle('hidden', emailRegex.test(emailInput.value));
}

function submitForm() {
    validateEmail();

    const formData = new FormData(document.querySelector('form'));

    formData.append('submit', 'Submit');

    fetch('../php/pre-registration.php', {
        method: 'POST',
        body: new URLSearchParams(formData)
    })
    .then(response => response.json())
    .then(data => {

        if (data.status === 'recorded') {
            document.getElementById("studentNumber").textContent = data.studentNumber;
            document.getElementById("password").textContent = data.password;

            document.getElementById("popup").classList.remove("hidden");
            
            const blobData = new Blob([`Student Number: ${data.studentNumber}\nPassword: ${data.password}`], { type: 'text/plain' });

            const downloadLink = document.createElement('a');
            downloadLink.href = window.URL.createObjectURL(blobData);
            downloadLink.download = 'student_credentials.txt';

            downloadLink.click();

            window.URL.revokeObjectURL(downloadLink.href);
        } else {
            console.error('Error recording data:', data);
        }
    })
    .catch(error => {
        console.error('Error fetching credentials:', error);
    });

    return false;
}

function goToLoginPage() {
    window.location.href = "../student/login.html";
}

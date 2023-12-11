function submitForm() {
    validateEmail();

    const formData = new FormData(document.querySelector('form'));
    formData.append('submit', 'Submit');

    fetch('../php/pre-registration.php', {
        method: 'POST',
        body: new URLSearchParams(formData),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Server response:', data);

            if (data && data.status === 'recorded') {
                document.getElementById('studentNumber').textContent = data.studentNumber;
                document.getElementById('password').textContent = data.password;

                document.getElementById('popup').classList.remove('hidden');

                const blobData = new Blob(
                    [`Student Number: ${data.studentNumber}\nPassword: ${data.password}`],
                    { type: 'text/plain' }
                );

                const downloadLink = document.createElement('a');
                downloadLink.href = window.URL.createObjectURL(blobData);
                downloadLink.download = 'student_credentials.txt';

                downloadLink.click();

                window.URL.revokeObjectURL(downloadLink.href);
            } else {
                console.error('Unexpected server response:', data);
            }
        })
        .catch(error => {
            console.error('Error fetching or processing data:', error);
        });

    return false;
}

function goToLoginPage() {
    window.location.href = "../login/student/login.php";
}

// Select the elements by their IDs
const emailInput = document.getElementById('email');
const emailStatus = document.getElementById('email_status');
const registerButton = document.getElementById('register_button');

emailInput.addEventListener('input', function () {
    // Check email availability via Ajax
    fetch('check_email.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ email: emailInput.value }), // Use URLSearchParams
    })
        .then(response => response.text())
        .then(data => {
            if (data === 'available') {
                emailStatus.textContent = 'Email is available.';
                emailStatus.style.color = 'green';
                registerButton.disabled = false;
            } else {
                emailStatus.textContent = 'Email is already registered.';
                emailStatus.style.color = 'red';
                registerButton.disabled = true;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

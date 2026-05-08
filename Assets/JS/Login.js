// Toggle between Login and Forgot Password views
function toggleViews(view) {
    const loginView = document.getElementById('loginView');
    const forgotView = document.getElementById('forgotView');
    if (view === 'forgot') {
        loginView.style.display = 'none';
        forgotView.style.display = 'flex';
    } else {
        loginView.style.display = 'flex';
        forgotView.style.display = 'none';
    }
}

function sendTestReset() {
    if (event) event.preventDefault();

    const empIdInput = document.getElementById('resetEmpId');
    const empId = empIdInput.value.trim();
    const btn = document.getElementById('forgotBtn');

    if (!empId) {
        alert("Please enter your Employee ID.");
        return;
    }

    const originalText = btn.innerText;
    btn.innerText = "Sending...";
    btn.disabled = true;

    const formData = new FormData();
    formData.append('employee_id', empId);

    fetch('../Config/forgotPassword.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        console.log("Raw response:", data);
        if (data.trim().toLowerCase() === 'success') {
            alert("Success! Check your registered email.");
            toggleViews('login');
        } else {
            alert("Server said: " + data);
        }
    })
    .catch(err => {
        console.error("Error:", err);
        alert("An error occurred. Check console for details.");
    })
    .finally(() => {
        btn.innerText = originalText;
        btn.disabled = false;
    });
}
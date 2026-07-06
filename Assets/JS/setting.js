// Bug Report Functions
function openBugReport() {
    document.getElementById("bugInput").value = "";
    document.getElementById("bugOverlay").style.display = "flex";
}

function closeBugReport() {
    document.getElementById("bugOverlay").style.display = "none";
}

function submitBug() {
    const bugText = document.getElementById("bugInput").value.trim();
    const btn = document.getElementById("submitBugBtn");
    const btnText = document.getElementById("btnText");
    const btnLoader = document.getElementById("btnLoader");

    if (bugText === "") {
        Swal.fire('Error', 'Please describe the issue.', 'error');
        return;
    }

    btn.disabled = true;      
    btn.style.opacity = "0.7";     
    btnText.style.display = "none";
    btnLoader.style.display = "inline-block";

    fetch('../Config/reportBug.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'bug_report=' + encodeURIComponent(bugText)
    })
    .then(res => res.text())
    .then(res => {
        if (res.includes("success")) {
            Swal.fire('Thank you!', 'Bug report sent to the Admins.', 'success');
            closeBugReport();
        } else {
            Swal.fire('Error', res, 'error');
        }
    })
    .catch(err => {
        Swal.fire('Error', 'Could not connect to the server.', 'error');
        console.error(err);
    });
}

// anything abt password start
async function openEditName() {
    const { value: formValues } = await Swal.fire({
        title: 'Edit Display Name',
        html:
            `<input id="swal-fn" class="swal2-input" placeholder="First Name">` +
            `<input id="swal-ln" class="swal2-input" placeholder="Last Name">`,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Save Changes',
        preConfirm: () => {
            return {
                fn: document.getElementById('swal-fn').value.trim(),
                ln: document.getElementById('swal-ln').value.trim()
            }
        }
    });

    if (formValues) {
        if (!formValues.fn || !formValues.ln) {
            Swal.fire('Error', 'Names cannot be empty.', 'error');
            return;
        }

        fetch('../Config/updateAccount.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=update_name&fn=${encodeURIComponent(formValues.fn)}&ln=${encodeURIComponent(formValues.ln)}`
        })
        .then(res => res.text())
        .then(res => {
            if (res.toLowerCase().includes("success")) { 
                Swal.fire('Success', 'Action completed!', 'success').then(() => {
                    location.reload(); 
                });
            } else {
                Swal.fire('Error', `Server sent: "${res}"`, 'error');
            }
        });
    }
}

async function openChangePassword() {
    const { value: formValues } = await Swal.fire({
        title: 'Change Password',
        html:
            '<input id="swal-curr" class="swal2-input" placeholder="Current Password" type="password">' +
            '<input id="swal-new" class="swal2-input" placeholder="New Password" type="password">' +
            '<input id="swal-conf" class="swal2-input" placeholder="Confirm New Password" type="password">',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Update Security',
        confirmButtonColor: '#d33',
        preConfirm: () => {
            return {
                curr: document.getElementById('swal-curr').value,
                next: document.getElementById('swal-new').value,
                conf: document.getElementById('swal-conf').value
            }
        }
    });

    if (formValues) {
        if (formValues.next !== formValues.conf) {
            Swal.fire('Error', 'New passwords do not match.', 'error');
            return;
        }

        fetch('../Config/updateAccount.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=update_pass&curr=${encodeURIComponent(formValues.curr)}&next=${encodeURIComponent(formValues.next)}`
        })
        .then(res => res.text())
        .then(res => {
            if (res.toLowerCase().includes("success")) { 
                Swal.fire('Success', 'Action completed!', 'success').then(() => {
                    location.reload(); 
                });
            } else {
                Swal.fire('Error', `Server sent: "${res}"`, 'error');
            }
        });
    }
}

// Close overlays on outside click
window.onclick = function (event) {
    if (event.target.id === "bugOverlay") closeBugReport();
}

// function toggleDarkMode() {
//     document.body.classList.toggle("dark-mode");
//     console.log("Dark mode:", document.body.classList.contains("dark-mode"));
//     localStorage.setItem(
//         "theme",
//         document.body.classList.contains("dark-mode") ? "dark" : "light"
//     );
// }

// Load saved theme
// if (localStorage.getItem("theme") === "dark") {
//     document.body.classList.add("dark-mode");
// }
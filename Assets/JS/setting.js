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

// Close overlays on outside click
window.onclick = function (event) {
    if (event.target.id === "bugOverlay") closeBugReport();
    if (event.target.id === "notifOverlay") closeNotif();
    if (event.target.classList.contains("modal-overlay")) {
        event.target.style.display = "none";
    }
}

function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
    console.log("Dark mode:", document.body.classList.contains("dark-mode"));
    localStorage.setItem(
        "theme",
        document.body.classList.contains("dark-mode") ? "dark" : "light"
    );
}

// Load saved theme
if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-mode");
}
function toggleMenu() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("collapsed");

    // Save the state to localStorage
    if (sidebar.classList.contains("collapsed")) {
        localStorage.setItem("sidebarState", "collapsed");
    } else {
        localStorage.setItem("sidebarState", "expanded");
    }
}

// Function to apply the saved state immediately on page load
(function() {
    const savedState = localStorage.getItem("sidebarState");
    const sidebar = document.getElementById("sidebar");
    
    if (sidebar && savedState === "collapsed") {
        sidebar.classList.add("collapsed");
    }
})();

function openNotif() { document.getElementById("notifOverlay").style.display = "flex"; }
function closeNotif() { document.getElementById("notifOverlay").style.display = "none"; }

function toggleNotif() {
    const dropdown = document.getElementById("notifDropdown");

    const isOpen = dropdown.style.display === "block";
    dropdown.style.display = isOpen ? "none" : "block";
}

function goToNotif(notifId, type, refId) {
    post('../Config/markNotifRead.php', { notif_id: notifId })
    .then(res => {
        if (res.trim() === "success") {
           if (type === 'ticket') {
                window.location.href = `../Flow/tileView.php?id=${refId}`;
            } else if (type === 'inventory') {
                window.location.href = `../Flow/inventory.php?id=${refId}`;
            } else if (type === 'maintenance') {
                window.location.href = `../Flow/maintenanceLog.php?id=${refId}`;
            } else {
                const notifItem = document.querySelector(`[onclick*="${notifId}"]`).closest('.notif-item');
                if(notifItem) notifItem.remove();
                updateNotifCount();
            }
        }
    });
}

function checkNewNotifs() {
    fetch('../Modules/header.php?ajax=notif_count')
    .then(res => res.json())
    .then(data => {
        const countEl = document.querySelector('.notif-count');
        if (countEl && data.count !== undefined) {
            if (data.count > 0) {
                countEl.innerText = data.count;
                countEl.style.display = 'block';
            } else {
                countEl.style.display = 'none';
            }
        }
    })
    .catch(err => console.log("Silent check failed"));
}

setInterval(checkNewNotifs, 15000);

function updateNotifCount() {
    const countEl = document.querySelector('.notif-count');
    const dropdown = document.getElementById('notifDropdown');
    
    if (!dropdown) return;

    const items = document.querySelectorAll('.notif-item.unread');
    const count = items.length;

    if (countEl) {
        if (count > 0) {
            countEl.innerText = count;
            countEl.style.display = 'block';
        } else {
            countEl.style.display = 'none';
        }
    }

    const allItems = dropdown.querySelectorAll('.notif-item:not(h4)');
    if (allItems.length === 0) {
        dropdown.innerHTML = '<h4>Notifications</h4><div class="notif-item">No notifications</div>';
    }
}

function deleteNotifOnly(notifId, btn) {
    if (!notifId || notifId === 0) return;

    fetch('../Config/markNotifRead.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'notif_id=' + notifId
    })
    .then(res => res.text())
    .then(res => {
        if (res.trim() === "success") {
            if (btn) {
                const notifElement = btn.closest('.notif-item');
                if (notifElement) {
                    notifElement.style.transition = 'opacity 0.5s';
                    notifElement.style.opacity = '0';
                    setTimeout(() => { 
                        notifElement.remove(); 
                        updateNotifCount();
                    }, 500);
                }
            } else {
                location.reload();
            }
        }
    })
    .catch(err => console.error("Fetch error:", err));
}

function clearAllNotifs() {
    if (!confirm("Mark all as read?")) return;

    fetch('../Config/markNotifRead.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'scope=all'
    })
    .then(res => res.text())
    .then(res => {
        if (res.trim() === "success") {
            const dropdown = document.getElementById('notifDropdown');
            const items = dropdown.querySelectorAll('.notif-item');
            
            items.forEach(item => {
                item.style.transition = 'opacity 0.3s';
                item.style.opacity = '0';
            });

            setTimeout(() => {
                dropdown.innerHTML = '<h4>Notifications</h4><div class="notif-item">No notifications</div>';
                updateNotifCount(); 
            }, 300);
        }
    })
    .catch(err => console.error("Error clearing notifications:", err));
}

// error pop-up for convinience
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    // Check for Errors
    if (urlParams.has('error')) {
        const errorType = urlParams.get('error');
        let message = "An unexpected error occurred.";

        // Map your database error codes to friendly messages
        if (errorType === 'db_fail') message = "Database transaction failed. Please check your inputs.";
        if (errorType === 'over_capacity') message = "Requested quantity exceeds current stock!";
        if (errorType === 'insufficient_stock') message = "Not enough items in inventory.";
        if (errorType === 'inventory_sync_fail') message = "Failed to sync with inventory database.";

        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
            confirmButtonColor: '#d33'
        });
    }

    // Check for Success
    if (urlParams.has('success') || urlParams.has('msg')) {
        const msgType = urlParams.get('success') || urlParams.get('msg');
        let message = "Action completed successfully!";

        if (msgType === 'updated') message = "Record updated successfully.";
        if (msgType === 'issued') message = "Inventory successfully issued.";

        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            timer: 3000,
            showConfirmButton: false
        });
    }
});
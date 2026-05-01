function checkSelection() {
    const checkedCount = document.querySelectorAll('.ticket-checkbox:checked').length;
    const actionMenu = document.getElementById('actionMenu');

    if (!actionMenu) {
        return; 
    }

    if (checkedCount > 0) {
        actionMenu.style.display = "inline-block";
    } else {
        actionMenu.style.display = "none";
    }
}

function toggleTicketFilter() {
    const overlay = document.getElementById("ticketFilterOverlay");
    overlay.style.display = (overlay.style.display === "flex") ? "none" : "flex";
}

// AJAX
function refreshTicketList() {
    if (document.querySelector('.ticket-checkbox:checked')) return;

    const overlay = document.querySelector('.inventory-filter-overlay');
    if (overlay && (overlay.style.display === 'block' || overlay.style.display === 'flex')) return;

    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('ajax', 'list');

    fetch('ticket.php?' + urlParams.toString())
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('ticket-list-container');
        if (data.tiles && data.tiles.trim() !== "") {
            container.innerHTML = data.tiles;
        }

        const oldToolbar = document.querySelector('.toolbar');
        if (oldToolbar && data.toolbar) {
            const temp = document.createElement('div');
            temp.innerHTML = data.toolbar;
            const newToolbar = temp.querySelector('.toolbar');
            if (newToolbar) oldToolbar.replaceWith(newToolbar);
        }
    })
    .catch(err => console.error("Failed to refresh tickets:", err));
}

let refreshInterval;

document.addEventListener("DOMContentLoaded", function () {
    refreshInterval = setInterval(refreshTicketList, 10000);
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('ticket-checkbox')) {
        stopRefresh();
    }
});

function stopRefresh() {
    clearInterval(refreshInterval);
}

function startRefresh() {
    clearInterval(refreshInterval);
    refreshInterval = setInterval(refreshTicketList, 10000);
}
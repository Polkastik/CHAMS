function checkSelection() {
    const checkedCount = document.querySelectorAll('.ticket-checkbox:checked').length;
    const actionMenu = document.getElementById('actionMenu');

    if (!actionMenu) return;

    if (checkedCount > 0) {
        actionMenu.style.display = "inline-block";
        actionMenu.style.opacity = '1';
        actionMenu.style.pointerEvents = 'auto';
    } else {
        actionMenu.style.display = "none";
        actionMenu.style.pointerEvents = 'none';
    }
}

function toggleTicketFilter() {
    const overlay = document.getElementById("ticketFilterOverlay");
    overlay.style.display = (overlay.style.display === "flex") ? "none" : "flex";
}

// AJAX
function refreshTicketList() {
    const activeSelection = document.querySelectorAll('.ticket-checkbox:checked').length;
    if (activeSelection > 0) return;

    const overlay = document.querySelector('.inventory-filter-overlay');
    if (overlay && window.getComputedStyle(overlay).display !== 'none') return;

    const dashContainer = document.getElementById('available-tickets-container');
    const listContainer = document.getElementById('ticket-list-container');

    if (dashContainer) {
        fetch('?ajax=available_tickets')
            .then(response => response.text())
            .then(html => {
                if (html.trim() !== "") {
                    dashContainer.innerHTML = html;
                }
            })
            .catch(err => console.error("Dashboard ticket refresh failed:", err));
    } else if (listContainer) {

        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('ajax', 'list');

        fetch('ticket.php?' + urlParams.toString())
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('ticket-list-container');
                if (data.tiles && container) {
                    container.innerHTML = data.tiles;
                }

                const oldToolbar = document.querySelector('.toolbar');
                if (oldToolbar && data.toolbar) {
                    const temp = document.createElement('div');
                    temp.innerHTML = data.toolbar;
                    const newToolbar = temp.querySelector('.toolbar');
                    if (newToolbar) oldToolbar.replaceWith(newToolbar);
                }
                
                checkSelection(); 
            })
            .catch(err => console.error("Failed to refresh tickets:", err));
    }

}

let refreshInterval;

document.addEventListener("DOMContentLoaded", function () {

    if (refreshInterval) {
        clearInterval(refreshInterval);
    }

    refreshInterval = setInterval(refreshTicketList, 10000);
});

function stopRefresh() {
    clearInterval(refreshInterval);
}

function startRefresh() {
    clearInterval(refreshInterval);
    refreshInterval = setInterval(refreshTicketList, 10000);
}
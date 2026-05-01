function toggleInventorySelect(element) {
    document.querySelectorAll('.custom-select').forEach(sel => {
        if (sel !== element) sel.classList.remove('active');
    });
    element.classList.toggle('active');
}

window.addEventListener('click', function (e) {
    if (!e.target.closest('.custom-select')) {
        document.querySelectorAll('.custom-select').forEach(sel => sel.classList.remove('active'));
    }
});

function confirmDelete(ticketNum) {
    if (confirm("WARNING: This will permanently remove Ticket #" + ticketNum + ". This action cannot be undone. Proceed?")) {
        
        window.location.href = "../Config/deleteTicket.php?tnum=" + encodeURIComponent(ticketNum);
    }
}

function confirmDeleteMaintenance(id) {
    if (confirm("WARNING: This will permanently remove Maintenance #" + id + ". This action cannot be undone. Proceed?")) {

        window.location.href = "../Config/deleteMaintenance.php?id=" + encodeURIComponent(id);
    }
}

function submitEditForm(form) {
    stopTileRefresh();
    
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: new URLSearchParams(formData)
    })
    .then(res => res.text())
    .then(res => {
        if (res.includes("success")) {
            refreshTileView(); 
        }
    })
    .catch(err => console.error("Edit error:", err));

    return; 
}
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
    const { value: password } = await Swal.fire({
        title: 'Delete Ticket #' + ticketNum + '?',
        text: "This action cannot be undone!",
        icon: 'warning',
        input: 'password',
        inputLabel: 'Enter Admin Password to confirm:',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete it!'
    });

    if (password) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../Config/deleteTicket.php';

        const tnumInput = document.createElement('input');
        tnumInput.name = 'tnum';
        tnumInput.value = ticketNum;
        form.appendChild(tnumInput);

        const passInput = document.createElement('input');
        passInput.name = 'confirm_password';
        passInput.value = password;
        form.appendChild(passInput);

        document.body.appendChild(form);
        form.submit();
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
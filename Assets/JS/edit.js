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

async function confirmDelete(ticketNum, id) {
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

        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        idInput.value = id;
        form.appendChild(idInput);

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

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const errorType = urlParams.get('error');

    if (errorType === 'wrong_password') {
        Swal.fire({
            icon: 'error',
            title: 'Authentication Failed',
            text: 'The password you entered is incorrect. Please try again.',
            confirmButtonColor: '#d33'
        });
    } else if (errorType === 'db_error') {
        Swal.fire({
            icon: 'warning',
            title: 'Database Error',
            text: 'We couldn\'t delete the ticket right now. Please contact system admin.',
        });
    }
});

window.promptDeduct = promptDeduct;

    async function promptDeduct(itemId, itemName, currentStock) {
    const { value: formValues } = await Swal.fire({
        title: `Deduct from ${itemName}`,
        html:
            '<label style="display:block; text-align:left;">Quantity to Deduct</label>' +
            '<input style="width: 80%;" id="swal-qty" class="swal2-input" type="number" min="1" max="' + currentStock + '">' +
            '<label style="display:block; text-align:left; margin-top:10px;">Target Department</label>' +
            `<select id="swal-dept" class="swal2-input">${globalDeptOptions}</select>`,
        focusConfirm: false,
        preConfirm: () => {
            const qty = document.getElementById('swal-qty').value;
            const dept = document.getElementById('swal-dept').value;
            if (!qty || !dept) {
                Swal.showValidationMessage('Both fields are required');
            }
            return { qty, dept };
        }
    });

    if (formValues) {
        const params = new URLSearchParams();
        params.append('action', 'deduct');
        params.append('item_id', itemId);
        params.append('qty', formValues.qty);
        params.append('d_id', formValues.dept);

        fetch('../Config/inventoryAction.php', {
            method: 'POST',
            body: params
        })
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.text();
        })
        .then(res => {
            console.log("Server Response:", res);
            if (res.trim().toLowerCase().includes("success")) {
                Swal.fire('Updated!', 'Stock has been deducted.', 'success')
                    .then(() => location.reload());
            } else {
                Swal.fire('Error', 'Server said: ' + res, 'error');
            }
        })
        .catch(err => {
            console.error("Fetch error:", err);
            Swal.fire('Upload Failed', 'Check console for details', 'error');
        });
    }
}
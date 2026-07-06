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

function exportTicketToDoc(format) {
    // 1. Safely scrape layout data parameters out of the existing HTML DOM inputs
    const pageHeader = document.getElementById('pageHeadText');
    let ticketNum = "UNKNOWN";
    
    if (pageHeader) {
        const headerText = pageHeader.innerText;
        const match = headerText.match(/VIEWING\s+([A-Za-z0-9-]+)/i);
        if (match && match[1]) {
            ticketNum = match[1].trim();
        }
    }

    // Safely extract grid row texts by searching label names
    function getGridValueByLabel(labelName) {
        const rows = document.querySelectorAll('.grid-row');
        for (let row of rows) {
            const labelEl = row.querySelector('.label');
            const valueEl = row.querySelector('.value');
            if (labelEl && labelEl.innerText.includes(labelName) && valueEl) {
                return valueEl.innerText.trim();
            }
        }
        return 'N/A';
    }

    const applicant = getGridValueByLabel('Applicant Name:');
    const category = getGridValueByLabel('Category:');
    const subCategory = getGridValueByLabel('Sub-Category:');
    const department = getGridValueByLabel('Department:');
    
    // Safely extract timing metrics out of status badge selectors
    const timeRow = document.querySelector('.status-row .badge');
    const dateTimeline = timeRow ? timeRow.innerText.trim() : new Date().toLocaleString();
    
    // Extract raw string descriptions and technician comments
    const descriptionBox = document.getElementById('dispMessage');
    const description = descriptionBox ? descriptionBox.innerText.trim() : "No description provided.";
    
    const commentBox = document.getElementById('commentSection');
    const techComments = commentBox ? commentBox.innerText.trim() : "No technical evaluation comments logged for this reference instance.";

    // Determine Status
    const statusBadges = document.querySelectorAll('.status-row .badge');
    let status = "Unresolved";
    statusBadges.forEach(badge => {
        if(badge.innerText.includes('Resolved') || badge.innerText.includes('Pending') || badge.innerText.includes('Unresolved')) {
            status = badge.innerText.trim();
        }
    });

    // 2. Build a formalized, print-optimized document structure
    let htmlContent = `
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; color: #333; padding: 20px; line-height: 1.6; }
                .header { text-align: center; border-bottom: 3px solid #0056b3; padding-bottom: 10px; margin-bottom: 20px; }
                .header h2 { margin: 0; color: #0056b3; text-transform: uppercase; }
                .header p { margin: 5px 0 0 0; font-size: 12px; color: #666; font-weight: bold; }
                .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                .meta-table td { padding: 8px; border: 1px solid #ddd; font-size: 14px; }
                .meta-table td.label { font-weight: bold; background-color: #f8f9fa; width: 25%; }
                .section-title { font-size: 16px; font-weight: bold; color: #0056b3; border-left: 4px solid #0056b3; padding-left: 8px; margin: 20px 0 10px 0; }
                .content-box { background: #fdfdfd; border: 1px solid #ddd; padding: 15px; border-radius: 4px; min-height: 60px; font-size: 14px; white-space: pre-wrap; }
                .footer { margin-top: 40px; text-align: center; font-size: 11px; color: #888; border-top: 1px solid #ddd; padding-top: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>Computerized Helpdesk & Asset Management System</h2>
                <p>CHAMS - SERVICE WORK ORDER REPORT</p>
            </div>

            <table class="meta-table">
                <tr>
                    <td class="label">Ticket Number:</td>
                    <td style="font-weight: bold; color: #0056b3;">${ticketNum}</td>
                    <td class="label">Date/Timeline:</td>
                    <td>${dateTimeline}</td>
                </tr>
                <tr>
                    <td class="label">Applicant Name:</td>
                    <td>${applicant}</td>
                    <td class="label">Department:</td>
                    <td>${department}</td>
                </tr>
                <tr>
                    <td class="label">Category:</td>
                    <td>${category}</td>
                    <td class="label">Sub-Category:</td>
                    <td>${subCategory}</td>
                </tr>
                <tr>
                    <td class="label">Current Status:</td>
                    <td colspan="3" style="font-weight: bold; color: #2c3e50;">${status}</td>
                </tr>
            </table>

            <div class="section-title">Incident / Request Description</div>
            <div class="content-box">${description}</div>

            <div class="section-title">Technical Support Actions & Comments</div>
            <div class="content-box">${techComments}</div>

            <div class="footer">
                This document is an official automated data compilation summary sheet generated by the CHAMS Server Platform.<br>
                Timestamp: ${new Date().toLocaleString()} | Reference Token: MN-SRC-${ticketNum}
            </div>
        </body>
        </html>
    `;

    // 3. Document processing routers
    if (format === 'word') {
        // Output clean byte array directly readable by Microsoft Word processing engines
        const blob = new Blob(['\ufeff' + htmlContent], { type: 'application/msword' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `Ticket_Report_${ticketNum}.doc`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    } else if (format === 'pdf') {
        // Spool the compilation block into a hardware print dialog overlay
        const printWindow = window.open('', '_blank', 'width=800,height=600');
        if (printWindow) {
            printWindow.document.write(htmlContent);
            printWindow.document.close();
            
            // Timeout padding ensures CSS layout registers cleanly before rendering the interface
            setTimeout(function() {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }, 500);
        } else {
            alert('Please allow popups to export the PDF file format report.');
        }
    }
}
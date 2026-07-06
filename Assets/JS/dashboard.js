function refreshActivity() {
    const loaderText = document.querySelector('#ticket-loader span');

    get('dashboard.php?ajax=activity')
        .then(html => {
            const container = document.getElementById('activityContainer');
            if (container) container.innerHTML = html;
        });

    get('dashboard.php?ajax=available_tickets')
        .then(html => {
            const container2 = document.getElementById('available-tickets-container');
            if (container2) container2.innerHTML = html;


            const loader = document.getElementById('ticket-loader');
            if (loader) loader.style.display = 'none';
        });
}

function updateActivityFeed() {
    get('dashboard.php?ajax_request=activity').then(html => {
        document.getElementById('recent-activity-list').innerHTML = html;
    });
}

// function claimTicket(id) {
//     post('../Config/updateAction.php', { action: 'accept', ticket_id: id })
//     .then(res => {
//         if(res.includes("success")) {
//             document.getElementById(`ticket-item-${id}`).style.opacity = '0';
//             setTimeout(() => document.getElementById(`ticket-item-${id}`).remove(), 500);
//             Swal.fire('Success', 'Ticket assigned to you', 'success');
//             refreshDashboard();
//         }
//     });
// }
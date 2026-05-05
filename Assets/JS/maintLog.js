function updateCountdowns() {
    document.querySelectorAll('.countdown').forEach(el => {
        let next = new Date(el.dataset.next).getTime();
        let now = new Date().getTime();
        let diff = next - now;

        if (diff <= 0) {
            el.innerHTML = "OVERDUE";
            return;
        }

        let days = Math.floor(diff / (1000 * 60 * 60 * 24));
        let hours = Math.floor((diff / (1000 * 60 * 60)) % 24);

        el.innerHTML = `${days}d ${hours}h`;
    });
}

<<<<<<< HEAD
setInterval(updateCountdowns, 1000);
=======
let maintInterval;

function startMaintRefresh() {
    maintInterval = setInterval(() => {
        const params = new URLSearchParams(window.location.search);
        params.set('ajax', 'list');

        fetch('maintenanceLog.php?' + params.toString())
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {

                const tbody = document.getElementById('maintenanceTableBody');
                if (tbody && data.table !== undefined) {
                    tbody.innerHTML = data.table;
                }

                const oldToolbar = document.querySelector('.toolbar');
                if (oldToolbar && data.toolbar) {
                    const temp = document.createElement('div');
                    temp.innerHTML = data.toolbar;
                    const newToolbar = temp.querySelector('.toolbar');
                    if (newToolbar) oldToolbar.replaceWith(newToolbar);
                }

            })
            .catch(err => console.error("Tracker refresh error:", err));
    }, 5000);
}

function stopMaintRefresh() {
    clearInterval(maintInterval);
}


startMaintRefresh();
setInterval(updateCountdowns, 60000);
>>>>>>> 7f37e85 (CHAMS VERSION 1)
updateCountdowns();
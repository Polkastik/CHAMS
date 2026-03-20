function refreshActivity() {

    if (!window.location.pathname.includes('profile')) return;

    fetch('profile.php?ajax=activity')
        .then(res => {
            if (!res.ok) throw new Error('Network error');
            return res.json();
        })
        .then(data => {

            const tbody = document.querySelector('.table-box tbody');
            if (tbody && data.table) {
                tbody.innerHTML = data.table;
            }

        })
        .catch(err => console.error("Activity refresh failed:", err));
}
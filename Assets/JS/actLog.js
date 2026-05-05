function refreshActivityList() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = parseInt(urlParams.get('page')) || 1;

    if (currentPage !== 1) return;

    const url = new URL(window.location.href);
    url.searchParams.set('ajax', 'list');
    url.searchParams.set('filterId', 'actLog');

    fetch('activityLog.php?' + url.searchParams.toString())
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('ticket-list-container');
            if (container && data.tiles) {
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
        .catch(err => console.error("Live Update Error:", err));
}

let actLogInterval;
function startActLogRefresh() {
    if (!actLogInterval) {
        actLogInterval = setInterval(refreshActivityList, 10000);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    startActLogRefresh();
});
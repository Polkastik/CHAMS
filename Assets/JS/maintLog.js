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

setInterval(updateCountdowns, 1000);
updateCountdowns();
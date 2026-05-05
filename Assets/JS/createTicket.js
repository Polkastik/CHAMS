document.addEventListener('DOMContentLoaded', function() {
    const ticketForm = document.getElementById('ticketForm');

    ticketForm.addEventListener('submit', function(event) {
        const title = document.getElementById('title').value.trim();
        const type = document.getElementById('type').value;
        const description = document.getElementById('description').value.trim();

        // if not filled and/or required tag removed in inspect
        if (!title || !type || !description) {
            event.preventDefault(); 
            alert("⚠️ Please fill in all required fields before submitting.");
            return false;
        }

        const submitBtn = document.querySelector('.btn-submit');
        submitBtn.innerText = "Creating...";
        submitBtn.disabled = true;
    });
});
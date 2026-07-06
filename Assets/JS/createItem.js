// 1. Define the function at the TOP (Global Scope)
window.updateBadgeStyle = function(element) {
    if (!element) return;
    
    // Clean old classes
    element.classList.remove('yes', 'no', 'unresolved', 'resolved');
    
    const val = element.value.toLowerCase().trim();
    
    if (val === 'yes') {
        element.classList.add('yes', 'unresolved'); // Red style
    } else if (val === 'no') {
        element.classList.add('no', 'resolved');    // Green style
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const itemForm = document.getElementById('ticketForm');
    const defectsSelect = document.getElementById('defectsSelect');
    const serialInput = document.querySelector('input[name="serial"]');

    // 2. Initialize the style on load
    if (defectsSelect) {
        updateBadgeStyle(defectsSelect);

        // 3. Add the listener for changes
        defectsSelect.addEventListener('change', function () {
            updateBadgeStyle(this);
        });
    }

    // 4. Formatting Serial Numbers
    if (serialInput) {
        serialInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/\s/g, '');
        });
    }

    // 5. Form Validation
    itemForm.addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const qty = document.querySelector('input[name="quantity"]').value;
        const category = document.getElementById('categ_id').value;
        const type = document.getElementById('type_id').value;

        if (title.length < 3) {
            e.preventDefault();
            alert("Please enter a valid Item Name (at least 3 characters).");
            return;
        }

        if (!category || !type) {
            e.preventDefault();
            alert("Please select both a Category and an Item Type.");
            return;
        }

        if (qty < 0) {
            e.preventDefault();
            alert("Quantity cannot be negative.");
            return;
        }

        const submitBtn = document.querySelector('.btn-submit');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
        submitBtn.style.opacity = '0.7';
        submitBtn.style.pointerEvents = 'none';
    });
});
// filter
function openInventoryFilter() {
    const overlay = document.getElementById("inventoryFilterOverlay");
    const panel = overlay.querySelector(".inventory-filter-panel");
    overlay.style.display = "block";
    setTimeout(() => panel.classList.add("show"), 10); 
}

function closeInventoryFilter() {
    const overlay = document.getElementById("inventoryFilterOverlay");
    const panel = overlay.querySelector(".inventory-filter-panel");
    panel.classList.remove("show"); 
    setTimeout(() => overlay.style.display = "none", 300); 
}

// dropdown
function toggleInventorySelect(el) {
    const active = el.classList.contains("active");

    document.querySelectorAll("#inventoryFilterOverlay .custom-select")
        .forEach(x => x.classList.remove("active"));

    if (!active) {
        el.classList.add("active");
    }
}

function setInvVal(id, value, event) {
    event.stopPropagation();
    document.getElementById(id).innerText = value;
    event.target.closest(".custom-select").classList.remove("active");
}

// modal
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('catModal');
    const closeBtn = document.getElementById('closeModal');

    // Function to open modal (call this from your Plus icon)
    window.openCategoryModal = function() {
        modal.style.display = 'flex';
    }

    // Close modal when clicking Cancel
    if (closeBtn) {
        closeBtn.onclick = function() {
            modal.style.display = 'none';
        }
    }

    // Close modal if user clicks anywhere outside the white box
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});

function openEditModal(id, name, desc, color) {
    document.getElementById('edit_cat_id').value = id;
    document.getElementById('edit_cat_name').value = name;
    document.getElementById('edit_cat_desc').value = desc;
    document.getElementById('edit_cat_color').value = color || '#e3f2fd';
    document.getElementById('editCategoryModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('editCategoryModal').style.display = 'none';
}

// AJAX

let inventoryRefresh;

function startInventoryRefresh() {
    const urlParams = new URLSearchParams(window.location.search);


    function buildUrl() {
        let base = "inventory.php?ajax=list";

        urlParams.forEach((value, key) => {
            base += `&${key}=${encodeURIComponent(value)}`;
        });

        return base;
    }

    inventoryRefresh = setInterval(() => {
        fetch(buildUrl())
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newList = doc.querySelector('#tileList');
                const currentList = document.querySelector('#tileList');

                if (newList && currentList) {
                    currentList.innerHTML = newList.innerHTML;
                }
            })
            .catch(err => console.error("Inventory AJAX error:", err));
    }, 5000);
}

function stopInventoryRefresh() {
    clearInterval(inventoryRefresh);
}

document.addEventListener("DOMContentLoaded", () => {
    startInventoryRefresh();
});
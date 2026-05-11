const FilterUI = {

    currentDate: new Date(),

    open(id) {
        const overlay = document.getElementById(id + "FilterOverlay");
        if (overlay) {
            overlay.style.display = "block";
            this.renderCalendar(id);
        }
    },

    close(id) {
        const overlay = document.getElementById(id + "FilterOverlay");
        if (overlay) overlay.style.display = "none";
    },

    set(id, key, value, e) {
        if (e) e.stopPropagation();

        // Update the label of the clicked dropdown
        document.getElementById(`${id}-${key}`).innerText = value;

        if (key === 'department') {
            this.updateNameDropdown(id, value);
        }

        // Close the dropdown
        document.querySelectorAll(`#${id}FilterOverlay .custom-filter`)
            .forEach(el => el.classList.remove("active"));
    },

    clear(id) {
        document.querySelectorAll(`#${id}FilterOverlay .select-value`)
            .forEach(el => {
                el.innerText = "All";
                el.removeAttribute('data-full-date');
            });
        document.querySelectorAll(`#${id}FilterOverlay .cal-date`)
            .forEach(el => el.classList.remove("selected"));
        const url = new URL(window.location.href);
        
        const keysToRemove = ['status', 'priority', 'overdue', 'unassigned', 'date', 'department', 'name', 'type'];
        keysToRemove.forEach(key => url.searchParams.delete(key));
        
        url.searchParams.delete('ajax');

        window.history.pushState({ path: url.href }, '', url.href);

        this.close(id);
        if (typeof startRefresh === 'function') startRefresh();
        if (typeof startTrackerRefresh === 'function') startTrackerRefresh();
    },

    apply(id) {
        if (typeof stopRefresh === 'function') stopRefresh();
        if (typeof stopTrackerRefresh === 'function') stopTrackerRefresh();
        if (typeof stopMaintRefresh === 'function') stopMaintRefresh();


        const url = new URL(window.location.href);
        const filterValues = document.querySelectorAll(`#${id}FilterOverlay .select-value`);

        filterValues.forEach(el => {
            const key = el.id.replace(`${id}-`, '');
            let value = el.textContent.trim();
            if (key === 'date' && el.getAttribute('data-full-date')) value = el.getAttribute('data-full-date');

            if (value && value.toLowerCase() !== 'all') {
                url.searchParams.set(key, value);
            } else {
                url.searchParams.delete(key);
            }
        });

        const flags = ['overdue', 'unassigned', 'priority'];
        const currentParams = new URLSearchParams(window.location.search);
        flags.forEach(flag => {
            if (currentParams.has(flag)) {
                url.searchParams.set(flag, currentParams.get(flag));
            }
        });

        url.searchParams.set('page', 1);
        url.searchParams.set('ajax', 'list');
        url.searchParams.set('filterId', id);

        const endpointMap = {
            ticketing: {
                url: 'ticket.php',
                tbody: 'ticketTableBody'
            },
            tracker: {
                url: 'inventoryTracker.php',
                tbody: 'trackerTableBody'
            },
            maintenance: {
                url: 'maintenanceLog.php',
                tbody: 'maintenanceTableBody'
            },
            actLog: {
                url: 'activityLog.php',
                tbody: 'activityTableBody'
            }
        };

        const config = endpointMap[id] || endpointMap['ticketing'];

        fetch(config.url + '?' + url.searchParams.toString())
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (config.tbody) {
                    const tbody = document.getElementById(config.tbody);
                    if (tbody && data.table) {
                        tbody.innerHTML = data.table;
                        tbody.style.opacity = '1';
                    }
                } else {
                    const tileContainer = document.getElementById('ticket-list-container');
                    if (tileContainer && data.tiles) tileContainer.innerHTML = data.tiles;
                }

                const oldToolbar = document.querySelector('.toolbar');
                if (oldToolbar && data.toolbar) {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data.toolbar;
                    const newToolbar = tempDiv.querySelector('.toolbar');
                    if (newToolbar) oldToolbar.replaceWith(newToolbar);
                }

                this.close(id);

                url.searchParams.delete('ajax');
                window.history.pushState({ path: url.href }, '', url.href);
                if (typeof startRefresh === 'function') startRefresh();
                if (typeof refreshTicketList === 'function') refreshTicketList();
                if (typeof startMaintRefresh === 'function') startMaintRefresh();
                if (id === 'tracker' && typeof startTrackerRefresh === 'function') startTrackerRefresh();
            })
            .catch(err => console.error("Filter Error:", err));
    },

    updateNameDropdown(id, selectedDept) {
        const nameLabel = document.getElementById(`${id}-name`);
        if (nameLabel) nameLabel.innerText = "All";

        const menu = document.querySelector(`[data-filter="name"] .filter-menu`);
        if (!menu) return;

        const names = DEPT_DATA[selectedDept] || ["All"];

        menu.innerHTML = names.map(name => `
            <div class="filter-item"
                onclick="FilterUI.set('${id}', 'name', '${name}', event)">
                ${name}
            </div>
        `).join('');
    },

    renderCalendar(id) {
        const container = document.getElementById(`${id}-calendar`);
        const monthText = document.getElementById(`${id}-month`);
        if (!container || !monthText) return;

        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        monthText.innerText = `${months[month]} ${year}`;
        container.innerHTML = "";

        for (let i = 0; i < firstDay; i++) {
            container.innerHTML += `<div class="cal-date muted"></div>`;
        }

        for (let d = 1; d <= lastDate; d++) {
            container.innerHTML += `
                <div class="cal-date" onclick="FilterUI.selectDate('${id}', this, ${d}, ${month + 1}, ${year})">
                    ${d}
                </div>`;
        }
    },

    selectDate(id, el, day, month, year) {
        document.querySelectorAll(`#${id}-calendar .cal-date`).forEach(d => d.classList.remove("selected"));
        el.classList.add("selected");

        const monthNames = [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];

        const paddedDay = String(day).padStart(2, '0');

        const displayDate = `${paddedDay} ${monthNames[month - 1]} ${year}`;

        const systemDate = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

        const dateLabel = document.getElementById(`${id}-date`);
        if (dateLabel) {
            dateLabel.innerText = displayDate;

            dateLabel.setAttribute('data-full-date', systemDate);
        }
    },

    changeMonth(step) {
        this.currentDate.setMonth(this.currentDate.getMonth() + step);
        const activeOverlay = document.querySelector('.inventory-filter-overlay[style*="display: block"]');
        if (activeOverlay) {
            const id = activeOverlay.id.replace("FilterOverlay", "");
            this.renderCalendar(id);
        }
    },

    goToPage(pageNum, id) {
        if (typeof stopRefresh === 'function') stopRefresh();
        if (typeof stopTrackerRefresh === 'function') stopTrackerRefresh();
        if (typeof stopMaintRefresh === 'function') stopMaintRefresh();
        if (typeof refreshActivityList === 'function') refreshActivityList();

        const url = new URL(window.location.href);

        const filterValues = document.querySelectorAll(`#${id}FilterOverlay .select-value`);

        filterValues.forEach(el => {
            const key = el.id.replace(`${id}-`, '');
            let value = el.textContent.trim();

            if (key === 'date' && el.getAttribute('data-full-date')) {
                value = el.getAttribute('data-full-date');
            }

            if (value && value.toLowerCase() !== 'all') {
                url.searchParams.set(key, value);
            } else {
                url.searchParams.delete(key);
            }
        });

        url.searchParams.set('page', pageNum);
        url.searchParams.set('ajax', 'list');
        url.searchParams.set('filterId', id);

        const endpointMap = {
            ticketing: {
                url: 'ticket.php',
            },
            tracker: {
                url: 'inventoryTracker.php',
                tbody: 'trackerTableBody'
            },
            maintenance: {
                url: 'maintenanceLog.php',
                tbody: 'maintenanceTableBody'
            },
            actLog: {
                url: 'activityLog.php',
            }
        };

        const config = endpointMap[id] || endpointMap['ticketing'];

        fetch(config.url + '?' + url.searchParams.toString())
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return (id === 'tracker') ? res.json() : res.json(); // all should be json ideally
            })
            .then(data => {

                if (config.tbody) {
                    const tbody = document.getElementById(config.tbody);
                    if (tbody && data.table) tbody.innerHTML = data.table;
                } else {
                    const container = document.getElementById('ticket-list-container');
                    if (container && data.tiles) container.innerHTML = data.tiles;
                }

                const oldToolbar = document.querySelector('.toolbar');
                if (oldToolbar && data.toolbar) {
                    const temp = document.createElement('div');
                    temp.innerHTML = data.toolbar;
                    const newToolbar = temp.querySelector('.toolbar');
                    if (newToolbar) oldToolbar.replaceWith(newToolbar);
                }

            })
            .catch(err => console.error("Pagination error:", err));

        url.searchParams.delete('ajax');
        window.history.pushState({ path: url.href }, '', url.href);

        if (typeof startRefresh === 'function') startRefresh();
        if (typeof refreshTicketList === 'function') refreshTicketList();
        if (typeof startMaintRefresh === 'function') startMaintRefresh();
        if (id === 'tracker' && typeof startTrackerRefresh === 'function') startTrackerRefresh();
        if (typeof refreshActivityList === 'function') refreshActivityList();
        if (pageNum === 1 && typeof refreshActivityList === 'function') { refreshActivityList(); }
    }
};

function toggleInventorySelect(element) {
    if (event) event.stopPropagation();

    document.querySelectorAll('.custom-filter, .custom-select').forEach(sel => {
        if (sel !== element) sel.classList.remove('active');
    });
    element.classList.toggle('active');
}

window.addEventListener('click', function (e) {
    if (!e.target.closest('.custom-filter, .custom-select')) {
        document.querySelectorAll('.custom-filter, .custom-select').forEach(sel => sel.classList.remove('active'));
    }
});

async function bulkAction(actionType) {
    const selectedCheckboxes = document.querySelectorAll('.ticket-checkbox:checked');
    const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);

    if (selectedIds.length === 0) {
        Swal.fire('Note', 'Please select at least one ticket.', 'info');
        return;
    }

    let adminPassword = null;
    if (actionType === 'delete') {
        const { value: password } = await Swal.fire({
            title: 'Confirm Admin Password',
            input: 'password',
            inputLabel: 'This action is permanent. Enter password to proceed:',
            inputPlaceholder: 'Enter your password',
            showCancelButton: true,
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            }
        });

        if (!password) return;
        adminPassword = password;
    }
        
    post('../Config/ticketAction.php', {
        action: 'bulk_' + actionType,
        ids: JSON.stringify(selectedIds),
        confirm_password: adminPassword
    })
        .then(data => {
            console.log("Server Response:", data);

            const responseString = typeof data === 'string' ? data : JSON.stringify(data);
            const isSuccess = responseString.toLowerCase().includes('success');
            
            if (!isSuccess) {
                Swal.fire('Error', 'Message: ' + responseString, 'error');
                return;
            }

            Swal.fire('Success!', 'Action Completed.', 'success');

            selectedCheckboxes.forEach(cb => {
                cb.checked = false;
                const row = cb.closest('tr');
                if (row) row.remove();
            });

            const selectAllBox = document.querySelector('input[type="checkbox"][onclick*="toggleSelectAll"]');
            if (selectAllBox) selectAllBox.checked = false;

            refreshTicketList();

            checkSelection();
        })

        .catch(err => {
            console.error("Full Error Response:", err);
            Swal.fire('Error', 'Server said: ' + err, 'error');
        });

}


function checkSelection() {
    const checkedCount = document.querySelectorAll('.ticket-checkbox:checked').length;
    const actionMenu = document.getElementById('actionMenu');

    if (!actionMenu) return;

    if (checkedCount > 0) {
        actionMenu.style.cursor = 'pointer';
        actionMenu.style.opacity = '1';
        actionMenu.style.color = '#000 !important';
        actionMenu.style.pointerEvents = 'auto';
    } else {
        actionMenu.style.cursor = 'not-allowed';
        actionMenu.style.opacity = '0.6';
        actionMenu.style.pointerEvents = 'none';
    }

}

function toggleSelectAll(source) {
    const checkboxes = document.querySelectorAll('.ticket-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = source.checked;
    });
    checkSelection();
}

window.addEventListener('click', function (event) {
    if (event.target.classList.contains('inventory-filter-overlay')) {
        const id = event.target.id.replace("FilterOverlay", "");
        FilterUI.close(id);

        if (typeof refreshTicketList === 'function') refreshTicketList();
        if (typeof startRefresh === 'function') startRefresh();
        if (typeof startTrackerRefresh === 'function') startTrackerRefresh();
        if (typeof startMaintRefresh === 'function') startMaintRefresh();
    }

    if (!event.target.closest('.custom-filter, .custom-select')) {
        document.querySelectorAll('.custom-filter, .custom-select').forEach(sel => {
            sel.classList.remove('active');
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);

    const summaryKeys = ['status', 'unassigned', 'overdue', 'priority'];

    const hasFilter = summaryKeys.some(key => urlParams.has(key));

    if (hasFilter) {
        FilterUI.apply('ticketing');
    }
});
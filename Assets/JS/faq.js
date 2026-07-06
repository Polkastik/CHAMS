function toggleMenu() {
            document.getElementById("sidebar").classList.toggle("collapsed");
        }
        function openNotif() { document.getElementById("notifOverlay").style.display = "flex"; }
        function closeNotif() { document.getElementById("notifOverlay").style.display = "none"; }
        function openModal(id) { document.getElementById(id).style.display = "flex"; }
        function closeModal(id) { document.getElementById(id).style.display = "none"; }
        function clearAllNotifs() { document.getElementById("notifList").innerHTML = '<p style="padding: 20px; opacity: 0.5; color: white;">No notifications</p>'; }

        // Toggle FAQ answers
        document.querySelectorAll(".faq-item").forEach(item => {
            item.addEventListener("click", () => {
                const answer = item.nextElementSibling;
                answer.style.display = (answer.style.display === "block") ? "none" : "block";
            });
        });

        // FAQ search logic
        const searchInput = document.querySelector(".search-faq input");
        searchInput.addEventListener("keyup", function () {
            let val = searchInput.value.toLowerCase();
            document.querySelectorAll(".faq-item").forEach(q => {
                let text = q.textContent.toLowerCase();
                if (text.includes(val)) {
                    q.style.display = "flex";
                } else {
                    q.style.display = "none";
                    q.nextElementSibling.style.display = "none";
                }
            });
        });
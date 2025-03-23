
document.addEventListener("DOMContentLoaded", function () {
    const notifBtn = document.getElementById("notifBtn");
    const notifDropdown = document.getElementById("notifDropdown");

    notifBtn.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevents clicking outside from closing immediately
        notifDropdown.style.display = notifDropdown.style.display === "block" ? "none" : "block";
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (event) {
        if (!notifBtn.contains(event.target) && !notifDropdown.contains(event.target)) {
            notifDropdown.style.display = "none";
        }
    });

    // // Simulated Notifications (replace with real backend notifications)
    // const notifList = document.getElementById("notifList");
    // const notifBadge = document.getElementById("notifBadge");

    // let notifications = [
    //     "PC 3 Shuts down",
    //     "PC 1 Starts up",
    //     "PC 2 File Transferred"
    // ];

    // if (notifications.length > 0) {
    //     notifBadge.classList.remove("d-none"); // Show badge
    //     notifBadge.innerText = notifications.length; // Update count
    //     notifList.innerHTML = notifications.map(notif => `<p class="small text-dark">${notif}</p>`).join("");
    // }
});


document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menuToggle");
    const nav = document.querySelector("nav");
    const topNavbar = document.getElementById("topNavbar");
    const dashCards = document.getElementById("dashCards");
    const monitoringSection = document.getElementById("monitoring-section");
    const controlSection = document.getElementById("control-section"); 
    const logSection = document.getElementById("logs-section"); 
    const dropdown = document.getElementById("userDropdown");


    function updateNavVisibility() {
        const screenWidth = window.innerWidth;

        if (screenWidth >= 769) {
            nav.classList.remove("nav-hidden");
            nav.classList.add("nav-open");
            menuToggleopen.classList.remove("menuToggle-move");
            topNavbar.classList.remove("navtopbar-move"); 
        } else {
            nav.classList.add("nav-hidden");
            nav.classList.remove("nav-open");
        }
    }

    menuToggle.addEventListener("click", function (event) {
        event.stopPropagation();
        nav.classList.toggle("nav-hidden");
        nav.classList.toggle("nav-open");
        menuToggle.classList.toggle("menuToggle-move");
        topNavbar.classList.toggle("navtopbar-move");

        // ✅ Adjust dashboard cards position when sidebar is toggled
        dashCards.classList.toggle("dashCards-move");

        // ✅ Adjust monitoring-section position when sidebar is toggled
        monitoringSection.classList.toggle("monitoring-move");

        // ✅ Adjust control-section position when sidebar is toggled
        controlSection.classList.toggle("control-move");

        logSection.classList.toggle("log-move");

         dropdown.classList.toggle("userDropdown-move"); // Toggle movement
    });

    document.addEventListener("click", function (event) {
        const screenWidth = window.innerWidth;
        if (screenWidth < 769) {
            if (!nav.contains(event.target) && !menuToggle.contains(event.target)) {
                nav.classList.add("nav-hidden");
                nav.classList.remove("nav-open");
                menuToggle.classList.remove("menuToggle-move");
                topNavbar.classList.remove("navtopbar-move");

                // ✅ Reset positions when clicking outside
                dashCards.classList.remove("dashCards-move");
                monitoringSection.classList.remove("monitoring-move");
                controlSection.classList.remove("control-move");
                logSection.classList.remove("log-move");
            }
        }
    });

    function updateNavVisibility() {
        let sidebar = document.getElementById("sidebar");
        let topNavbar = document.getElementById("topNavbar");
    
        if (window.innerWidth > 768) { 
            sidebar.classList.remove("active");  // Close sidebar if screen is large
            sidebar.style.transform = "translateX(-100%)"; // Move sidebar completely out
            topNavbar.classList.remove("navtopbar-move");
        } else {
            sidebar.style.transform = ""; // Reset when in mobile view
        }
    }
    
    // Call the function on page load
    updateNavVisibility();
    
    // Listen for screen resize events
    window.addEventListener("resize", updateNavVisibility);
    
});
document.addEventListener("DOMContentLoaded", function () {
    const selectAllBtn = document.getElementById("selectAll");
    const section = document.getElementById("control-section");

    if (!selectAllBtn || !section) {
        console.error("Elements not found.");
        return;
    }

    selectAllBtn.addEventListener("click", function () {
        console.log("Select All clicked!");

        const items = section.querySelectorAll(".pc-item");

        if (items.length === 0) {
            console.error("No .pc-item elements found.");
            return;
        }

        // Check if all items are already selected
        let allSelected = [...items].every(item => item.classList.contains("selected"));

        // Toggle selection
        items.forEach(item => {
            if (!allSelected) {
                item.classList.add("selected");
                item.click(); // Simulate click
            } else {
                item.classList.remove("selected");
            }
        });
    });
});



// PARA PANG TOGGLE NG NIGHT MODE
 document.body.classList.add('light');

        document.getElementById('switchBtn').addEventListener('click', () => { 
            document.body.classList.toggle('dark');
            document.body.classList.toggle('light');

            // Get the <i> element inside the button
            const icon = document.querySelector("#switchBtn i");

            // Toggle icon classes correctly
            if (document.body.classList.contains('dark')) {
                icon.classList.remove('fa-moon');  // Remove moon icon
                icon.classList.add('fa-sun');     // Add sun icon
            } else {
                icon.classList.remove('fa-sun');  // Remove sun icon
                icon.classList.add('fa-moon');    // Add moon icon
            }
        });

// palit ng theme
document.addEventListener("DOMContentLoaded", function () {
    const switchBtn = document.getElementById("switchBtn");
    const body = document.body;
    const icon = switchBtn.querySelector("i");

    // Apply the saved theme from local storage
    if (localStorage.getItem("theme") === "dark") {
        body.setAttribute("data-theme", "dark");
        icon.classList.remove("fa-moon");
        icon.classList.add("fa-sun");
    } else {
        body.setAttribute("data-theme", "light");
        icon.classList.remove("fa-sun");
        icon.classList.add("fa-moon");
    }

    // Theme toggle button
    switchBtn.addEventListener("click", function () {
        if (body.getAttribute("data-theme") === "dark") {
            body.setAttribute("data-theme", "light");
            localStorage.setItem("theme", "light");
            icon.classList.remove("fa-sun");
            icon.classList.add("fa-moon");
        } else {
            body.setAttribute("data-theme", "dark");
            localStorage.setItem("theme", "dark");
            icon.classList.remove("fa-moon");
            icon.classList.add("fa-sun");
        }
    });
});




// PANG OPEN NG SELECTION SA MGA PC
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".pc-item").forEach(pc => {
        let controls = pc.querySelector(".pc-controls");

        pc.addEventListener("click", function (event) {
            // Check if the click is inside .pc-controls, ignore it
            if (event.target.closest(".pc-controls")) return;

            // Toggle the display of controls
            if (controls.style.display === "none" || controls.style.display === "") {
                controls.style.display = "flex"; // Show controls
            } else {
                controls.style.display = "none"; // Hide controls
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const advOptButton = document.querySelectorAll(".adv-opt");
    const advModal = document.getElementById("advOptionsModal");

    document.querySelectorAll(".pc-controls button").forEach(button => {
        button.addEventListener("click", function (event) {
            event.stopPropagation();

            let action = this.getAttribute("title");

            if (action === "Advanced Options") {
                this.disabled = true;

                let modal = new bootstrap.Modal(advModal);
                modal.show();

                advModal.addEventListener("hidden.bs.modal", () => {
                    this.disabled = false;
                }, { once: true }); 
            } 
            else if (action !== "View Background Processes") {
                alert(`${action} command sent.`);
            }
        });
    });
});



// PARA SA LOGS
document.addEventListener("DOMContentLoaded", function () {
    const logSearch = document.getElementById("logSearch");
    const logFilter = document.getElementById("logFilter");
    const logsTable = document.getElementById("logsTable");

    logSearch.addEventListener("input", filterLogs);
    logFilter.addEventListener("change", filterLogs);

    function filterLogs() {
        let searchQuery = logSearch.value.toLowerCase().replace(/\s+/g, ""); // Remove spaces
        let filterType = logFilter.value.toLowerCase();
        
        Array.from(logsTable.getElementsByTagName("tr")).forEach(row => {
            let logText = row.innerText.toLowerCase().replace(/\s+/g, ""); // Remove spaces from log text
            let actionText = row.cells[2]?.innerText.toLowerCase() || ""; // Action column
            let matchesSearch = logText.includes(searchQuery);
            let matchesFilter = filterType === "all" || actionText.includes(filterType);

            row.style.display = matchesSearch && matchesFilter ? "" : "none";
        });
    }
});


// PANG SWITCH NG SECTION
document.addEventListener("DOMContentLoaded", function () {
    const dashboardSection = document.getElementById("dashCards");
    const monitoringSection = document.getElementById("monitoring-section");
    const controlSection = document.getElementById("control-section"); // Control Section
    const logSection = document.getElementById("logs-section"); // Control Section


    // Sidebar links
    const dashboardLink = document.querySelector("a[href='#dashboard']");
    const monitoringLink = document.querySelector("a[href='#monitoring-section']");
    const controlLink = document.querySelector("a[href='#control-section']"); // Control Section Link
    const logsLink = document.querySelector("a[href='#logs-section']"); // ✅ Added Logs Link

    function showSection(section) {
        if (section === "dashboard") {
            dashboardSection.style.display = "block";
            monitoringSection.style.display = "none";
            controlSection.style.display = "none";
            logSection.style.display = "none"; // ✅ Hide logs when other sections are shown
        } else if (section === "monitoring") {
            dashboardSection.style.display = "none";
            monitoringSection.style.display = "block";
            controlSection.style.display = "none";
            logSection.style.display = "none";
        } else if (section === "control") {
            dashboardSection.style.display = "none";
            monitoringSection.style.display = "none";
            controlSection.style.display = "block";
            logSection.style.display = "none";
        } else if (section === "logs") {
            dashboardSection.style.display = "none";
            monitoringSection.style.display = "none";
            controlSection.style.display = "none";
            logSection.style.display = "block"; // ✅ Show logs when logs link is clicked
        }
    }


    if (dashboardLink) {
        dashboardLink.addEventListener("click", function (e) {
            e.preventDefault();
            showSection("dashboard");
        });
    }

    if (monitoringLink) {
        monitoringLink.addEventListener("click", function (e) {
            e.preventDefault();
            showSection("monitoring");
        });
    }

    if (controlLink) {
        controlLink.addEventListener("click", function (e) {
            e.preventDefault();
            showSection("control");
        });
    }
    if (logsLink) {
    logsLink.addEventListener("click", function (e) {
        e.preventDefault();
        showSection("logs");
    });
}

    // Show only the dashboard by default
    showSection("dashboard");
});


    
    // Modal functions
    function openModal(pcName, vncPort) {
        const modal = document.getElementById("pcModal");
        document.getElementById("pcTitle").textContent = "PC Name: " + pcName;
        document.getElementById("vnc").src = "http://localhost:" + vncPort + "/vnc.html";
        modal.style.display = "block";
        modal.classList.add("show");
        modal.style.visibility = "visible";
    }
    
    function closeModal() {
        selectedPcId = null;
        const modal = document.getElementById("pcModal");
        modal.style.display = "none";
        modal.classList.remove("show");
        document.getElementById("vnc").src = "";
    }
  

// Close when clicking outside
document.getElementById("pcModal").addEventListener("click", closeModal);

document.querySelector(".modal-content").addEventListener("click", function(event) {
    event.stopPropagation();
});



// Send Chat Message
function sendMessage(event) {
    // Allow sending via Enter key or button click
    if (!event || event.key === "Enter") {  
        let chatInput = document.getElementById("chatInput");
        let chatMessages = document.getElementById("chatMessages");

        if (chatInput.value.trim() !== "") {
            let message = document.createElement("p");
            message.classList.add("sent-message");
            message.innerText = chatInput.value;
            chatMessages.appendChild(message);
            chatInput.value = ""; // Clear input after sending
            chatMessages.scrollTop = chatMessages.scrollHeight; // Auto-scroll to latest message
        }
    }
}

// Attach event listener to the send button
document.getElementById("sendButton").addEventListener("click", function () {
    sendMessage(); // Call sendMessage when the button is clicked
});

document.getElementById("fileInput").addEventListener("change", function () {
    let file = this.files[0]; // Get the selected file
    if (file) {
        let chatMessages = document.getElementById("chatMessages");

        // Create a file message container
        let fileMessage = document.createElement("p");
        fileMessage.classList.add("sent-message");

        // Create an object URL for local preview
        let fileURL = URL.createObjectURL(file);

        // Display a clickable file link
        fileMessage.innerHTML = `
            <a href="${fileURL}" download="${file.name}" target="_blank">
                <i class="fas fa-file"></i> ${file.name}
            </a>
        `;

        chatMessages.appendChild(fileMessage);
        this.value = "";

        // Scroll to latest message
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});


// Open Chat Modal
document.getElementById("chatToggle").addEventListener("click", function () {
    let chatModal = document.getElementById("chatModal");

    if (chatModal.style.display === "none" || chatModal.style.display === "") {
        chatModal.style.display = "block"; // Open modal
    } else {
        chatModal.style.display = "none"; // Close modal
    }
});


// Close Chat Modal
function closeChatModal() {
    document.getElementById("chatModal").style.display = "none";
}


// para sa gap to ng mga PCs sa monitoring-section
document.addEventListener("DOMContentLoaded", function () {
    function adjustGap() {
        const pcItems = document.querySelectorAll(".pc-item").length;
        let newGap = 120; // Default gap

        if (pcItems > 10) {
            newGap = Math.max(10, 120 * Math.pow(0.1, pcItems - 10));
        }

        document.documentElement.style.setProperty("--dynamic-gap", `${newGap}px`);
    }

    adjustGap(); // Call on page load

    // Optional: Call adjustGap() when new PCs are added dynamically
    const observer = new MutationObserver(adjustGap);
    observer.observe(document.querySelector(".pc-grid"), { childList: true });
});


// ADD NG PC SA MONITORING SECTION
document.addEventListener("DOMContentLoaded", function () {
    let confirmAddPc = document.getElementById("confirmAddPc");

    if (confirmAddPc) {
        confirmAddPc.addEventListener("click", addPc);
    }
});

function addPc() {
    let ip = document.getElementById("pc-ip").value;
    let port = document.getElementById("pc-port").value;

    if (!ip || !port) {
        alert("Please enter both IP address and port.");
        return;
    }

    fetch('/add-pc', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ ip_address: ip, port: port })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("PC Added Successfully!");
            let modal = bootstrap.Modal.getInstance(document.getElementById("addPcModal"));
            modal.hide(); // Close modal
            location.reload(); // Refresh UI
        } else {
            alert("Error adding PC.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Failed to add PC.");
    });
}




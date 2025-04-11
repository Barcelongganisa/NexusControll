document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menuToggle");
    const nav = document.querySelector("nav");
    const navtop = document.getElementById("navtop");
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
            menuToggle.classList.remove("menuToggle-move");

            if (topNavbar) topNavbar.classList.remove("navtopbar-move"); 
            if (navtop) navtop.classList.remove("navtop-move");
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

        // ✅ Ensure both navtop and topNavbar move together
        if (navtop) navtop.classList.toggle("navtop-move");
        if (topNavbar) topNavbar.classList.toggle("navtopbar-move");

        // ✅ Adjust other sections accordingly
        dashCards.classList.toggle("dashCards-move");
        monitoringSection.classList.toggle("monitoring-move");
        controlSection.classList.toggle("control-move");
        logSection.classList.toggle("log-move");
        dropdown.classList.toggle("userDropdown-move");
    });

    document.addEventListener("click", function (event) {
        const screenWidth = window.innerWidth;
        if (screenWidth < 769) {
            if (!nav.contains(event.target) && !menuToggle.contains(event.target)) {
                nav.classList.add("nav-hidden");
                nav.classList.remove("nav-open");
                menuToggle.classList.remove("menuToggle-move");

                if (topNavbar) topNavbar.classList.remove("navtopbar-move");
                if (navtop) navtop.classList.remove("navtop-move");

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
            sidebar.classList.remove("active");  
            sidebar.style.transform = "translateX(-100%)";  
            if (topNavbar) topNavbar.classList.remove("navtopbar-move");
        } else {
            sidebar.style.transform = "";  
        }
    }

    updateNavVisibility();
    window.addEventListener("resize", updateNavVisibility);
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


// SELECT ALL SA CONTROl
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
        const checkboxes = section.querySelectorAll(".pc-checkbox");

        if (items.length === 0 || checkboxes.length === 0) {
            console.error("No .pc-item or .pc-checkbox elements found.");
            return;
        }

        // Check if all are already selected
        const allSelected = Array.from(checkboxes).every(cb => cb.checked);

        checkboxes.forEach(cb => {
            cb.checked = !allSelected;

            const pcItem = cb.closest(".pc-item");
            const pcControls = pcItem.querySelector(".pc-controls");

            if (!allSelected) {
                pcItem.classList.add("selected");
                pcControls.style.display = "flex";
            } else {
                pcItem.classList.remove("selected");
                pcControls.style.display = "none";
            }
        });
    });
});


    // function updateStatuses() {
    //     fetch('/update-status') // This hits your Laravel route
    //         .then(response => response.json())
    //         .then(data => console.log(data.message));
    // }

    // // Call every 10 seconds
    // setInterval(updateStatuses, 10000);


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


    
    // Modal functions for VNC
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
// document.getElementById("pcModal").addEventListener("click", closeModal);

document.querySelector(".modal-content").addEventListener("click", function(event) {
    event.stopPropagation();
});


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
    let pcPortInput = document.getElementById("pc-port");

    const addPcModal = document.getElementById("addPcModal");
    addPcModal.addEventListener("show.bs.modal", function () {
        fetch('/next-port')
            .then(response => response.json())
            .then(data => {
                pcPortInput.value = data.next_port;
            })
            .catch(error => {
                console.error("Failed to fetch next port:", error);
                pcPortInput.value = 6080;
            });
    });

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
    console.log("Response from server:", data);
    if (data.success) {
        alert("PC Added Successfully!");
        let modal = bootstrap.Modal.getInstance(document.getElementById("addPcModal"));
        modal.hide();
        location.reload();
    } else {
        alert("Error adding PC: " + (data.error || "Unknown error"));
    }
})
.catch(error => {
    console.error("Fetch error:", error);
    alert("Failed to add PC.");
});

}

// paginate
    document.addEventListener('DOMContentLoaded', function () {
        const rowsPerPage = 10;
        const tableBody = document.querySelector('.logsTable tbody');
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        const paginationContainer = document.createElement('div');
        paginationContainer.classList.add('pagination', 'mt-4', 'text-center');

        function showPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? '' : 'none';
            });
        }

        function createPaginationLinks() {
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.classList.add('px-3', 'py-1', 'm-1', 'border', 'rounded', 'bg-gray-200', 'hover:bg-gray-300');
                btn.addEventListener('click', () => showPage(i));
                paginationContainer.appendChild(btn);
            }

            // Append below the table
            const tableContainer = document.querySelector('.logsTable');
            tableContainer.parentElement.appendChild(paginationContainer);
        }

        showPage(1);
        createPaginationLinks();
    });

// document.getElementById("menuToggle").addEventListener("click", function() {
//     const navtop = document.getElementById("navtop");
//     navtop.classList.toggle("navtop-move");
// });


document.addEventListener("DOMContentLoaded", function () {
    const globalFileInput = document.getElementById("globalFileInput");

    globalFileInput.addEventListener("change", function () {
        const file = globalFileInput.files[0];
        if (!file) return;

        const checkedCheckboxes = document.querySelectorAll(".pc-checkbox:checked");

        checkedCheckboxes.forEach(checkbox => {
            const ip = checkbox.dataset.ip;
            const fileInput = document.getElementById(`fileInput-${ip}`);
            const form = fileInput.closest("form");
            const progressContainer = form.querySelector(".progress-container");
            const progressBar = form.querySelector(".progress-bar");
            const pcControls = form.closest(".pc-controls");
            const buttons = pcControls.querySelectorAll("button, input[type='file']");

            // Clone the file to make it work across FormData instances
            const fileClone = new File([file], file.name, { type: file.type });

            const formData = new FormData(form);
            formData.set("file", fileClone);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", form.action, true);
            xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

            // Hide all buttons while uploading
            buttons.forEach(btn => btn.style.display = "none");

            progressContainer.style.display = "block";
            // progressBar.style.width = "0%";
            // progressBar.textContent = "0%";

            xhr.upload.onprogress = function (event) {
                if (event.lengthComputable) {
                    let percent = (event.loaded / event.total) * 100;
                    progressBar.style.width = percent + "%";
                    progressBar.textContent = Math.round(percent) + "%";
                }
            };

            xhr.onload = function () {
                    if (xhr.status === 200) {
                        progressBar.style.width = "100%";
                        progressBar.textContent = "Upload Complete!";
                        setTimeout(() => {
                            progressContainer.style.display = "none";
                            progressBar.style.width = "0%";
                            buttons.forEach(btn => btn.style.display = "inline-block");
                            fileInput.style.display = "none";
                        }, 2000);
                    } else {
                        progressBar.style.width = "0%";
                        progressBar.textContent = "Upload Failed!";
                        setTimeout(() => {
                            progressContainer.style.display = "none";
                            buttons.forEach(btn => btn.style.display = "inline-block");
                            fileInput.style.display = "none";
                        }, 2000);
                    }
                };

            xhr.send(formData);
        });

        // Reset the global input
        globalFileInput.value = "";
    });
});

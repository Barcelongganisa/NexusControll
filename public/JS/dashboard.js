// dashboard.js - Compiled and optimized

// ==================== GLOBAL VARIABLES ====================
let subPcSocket = null;
// let selectedIp = null;
let multiMode = false;
let selectedIps = [];
const timers = {}; // Store countdown intervals per IP

// ==================== GLOBAL FUNCTIONS (needed for inline onclick) ====================
window.openModal = function(pcName, vncPort) {
    const modal = document.getElementById("pcModal");
    document.getElementById("pcTitle").textContent = "PC Name: " + pcName;
    document.getElementById("vnc").src = "http://localhost:" + vncPort + "/vnc.html";
    modal.style.display = "block";
    modal.classList.add("show");
    modal.style.visibility = "visible";
    
    if (subPcSocket) {
        subPcSocket.disconnect();
    }
    subPcSocket = io(`http://${pcName}:5000`);
    
    subPcSocket.on("subpc_reply", function(data) {
        const message = data.message;
        addChatMessage("Sub PC", message);
    });
};

window.closeModal = function() {
    const modal = document.getElementById("pcModal");
    modal.style.display = "none";
    modal.classList.remove("show");
    document.getElementById("vnc").src = "";
    
    if (subPcSocket) {
        subPcSocket.disconnect();
        subPcSocket = null;
    }
    const chatContainer = document.getElementById("chatMessages");
    if (chatContainer) chatContainer.innerHTML = "";
};

window.sendMessage = function(event) {
    if (event && event.key !== "Enter" && event.type !== 'click') return;
    const input = document.getElementById("chatInput");
    if (!input) return;
    
    const message = input.value.trim();
    if (message !== "" && subPcSocket) {
        subPcSocket.emit("server_message", { message });
        addChatMessage("You", message);
        input.value = "";
    }
};

window.closeChatModal = function() {
    document.getElementById("chatModal").style.display = "none";
};

function addChatMessage(sender, message) {
    const chatContainer = document.getElementById("chatMessages");
    if (!chatContainer) return;
    
    const wrapper = document.createElement("div");
    wrapper.className = sender === "You" ? "message-wrapper you" : "message-wrapper subpc";
    
    const bubble = document.createElement("div");
    bubble.className = "chat-message";
    bubble.innerHTML = `<strong>${sender}:</strong> ${message}`;
    
    wrapper.appendChild(bubble);
    chatContainer.appendChild(wrapper);
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

// ==================== MAIN INITIALIZATION ====================
document.addEventListener("DOMContentLoaded", function() {
    // Initialize Bootstrap modals first
    initializeBootstrapModals();
    
    // Then initialize everything else
    initializeElements();
    initializeEventListeners();
    initializeTheme();
    initializePagination();
    initializeCountdowns();
    
    // Start periodic updates
    startPeriodicUpdates();
});

// ==================== BOOTSTRAP MODAL INITIALIZATION ====================
function initializeBootstrapModals() {
    // Make sure Bootstrap is loaded
    if (typeof bootstrap !== 'undefined') {
        // Initialize lock timer modal
        const lockTimerModalEl = document.getElementById('lockTimerModal');
        if (lockTimerModalEl) {
            // Store modal instance for later use
            window.lockTimerModal = new bootstrap.Modal(lockTimerModalEl);
        }
        
        // Initialize request modal
        const requestModalEl = document.getElementById('requestModal');
        if (requestModalEl) {
            window.requestModal = new bootstrap.Modal(requestModalEl);
        }
        
        // Initialize add PC modal
        const addPcModalEl = document.getElementById('addPcModal');
        if (addPcModalEl) {
            window.addPcModal = new bootstrap.Modal(addPcModalEl);
        }
    }
}

// ==================== ELEMENT CACHE ====================
let elements = {};

function initializeElements() {
    elements = {
        menuToggle: document.getElementById("menuToggle"),
        nav: document.querySelector("nav"),
        navtop: document.getElementById("navtop"),
        topNavbar: document.getElementById("topNavbar"),
        dashCards: document.getElementById("dashCards"),
        monitoringSection: document.getElementById("monitoring-section"),
        controlSection: document.getElementById("control-section"),
        logSection: document.getElementById("logs-section"),
        dropdown: document.getElementById("userDropdown"),
        switchBtn: document.getElementById("switchBtn"),
        selectAllBtn: document.getElementById("selectAll"),
        globalFileInput: document.getElementById("globalFileInput"),
        chatToggle: document.getElementById("chatToggle"),
        chatModal: document.getElementById("chatModal"),
        chatInput: document.getElementById("chatInput"),
        chatMessages: document.getElementById("chatMessages"),
        confirmAddPc: document.getElementById("confirmAddPc"),
        pcIpInput: document.getElementById("pc-ip"),
        pcPortInput: document.getElementById("pc-port"),
        lockTimerForm: document.getElementById('lockTimerForm'),
        multiLockTimer: document.getElementById('multiLockTimer'),
        multiFileRequest: document.getElementById('multiFileRequest'),
        sendRequestBtn: document.getElementById('sendRequestBtn'),
        requestModal: document.getElementById('requestModal'),
        modalPcName: document.getElementById('modalPcName'),
        requestMessage: document.getElementById('requestMessage'),
        processModal: document.getElementById('process-modal'),
        processModalContent: document.getElementById('process-modal-content'),
        closeModalBtn: document.getElementById('close-modal'),
        lockTimerPcIp: document.getElementById('lockTimerPcIp'),
        lockTimerHours: document.getElementById('lockTimerHours'),
        lockTimerMinutes: document.getElementById('lockTimerMinutes'),
        lockTimerSeconds: document.getElementById('lockTimerSeconds')
    };
}

// ==================== EVENT LISTENERS ====================
function initializeEventListeners() {
    // Navigation
    if (elements.menuToggle) {
        elements.menuToggle.addEventListener("click", toggleMenu);
        document.addEventListener("click", handleDocumentClick);
        window.addEventListener("resize", debounce(updateNavVisibility, 250));
    }
    
    // Theme toggle
    if (elements.switchBtn) {
        elements.switchBtn.addEventListener("click", toggleTheme);
    }
    
    // PC item clicks for showing controls
    document.querySelectorAll(".pc-item").forEach(pc => {
        pc.addEventListener("click", handlePcItemClick);
    });
    
    // Select all button
    if (elements.selectAllBtn) {
        elements.selectAllBtn.addEventListener("click", handleSelectAll);
    }
    
    // Section switching
    initializeSectionSwitching();
    
    // Logs filtering
    initializeLogsFiltering();
    
    // Add PC modal - fetch next port when opening
    const addPcModal = document.getElementById("addPcModal");
    if (addPcModal) {
        addPcModal.addEventListener("show.bs.modal", function() {
            fetchNextPort();
        });
    }
    
    // Add PC button
    if (elements.confirmAddPc) {
        elements.confirmAddPc.addEventListener("click", addPc);
    }
    
    // Global file upload
    if (elements.globalFileInput) {
        elements.globalFileInput.addEventListener("change", handleGlobalFileUpload);
    }
    
    // Chat toggle
    if (elements.chatToggle) {
        elements.chatToggle.addEventListener("click", toggleChatModal);
    }
    
    // Control buttons (shutdown, restart, lock)
    initializeControlButtons();
    
    // Lock timer buttons
    initializeLockTimerButtons();
    
    // Multi lock timer
    if (elements.multiLockTimer) {
        elements.multiLockTimer.addEventListener('click', handleMultiLockTimer);
    }
    
    // Lock timer form
    if (elements.lockTimerForm) {
        elements.lockTimerForm.addEventListener('submit', handleLockTimerSubmit);
    }
    
    // Request buttons
    initializeRequestButtons();
    
    // Multi file request
    if (elements.multiFileRequest) {
        elements.multiFileRequest.addEventListener('click', handleMultiFileRequest);
    }
    
    // Send request button
    if (elements.sendRequestBtn) {
        elements.sendRequestBtn.addEventListener('click', sendRequest);
    }
    
    // Process viewer
    initializeProcessViewer();
    
    // File upload forms
    initializeFileUploadForms();
}

// ==================== UTILITY FUNCTIONS ====================
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function showAlert(type, title, message, timer = 2000) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: type,
            title: title,
            text: message,
            timer: timer,
            showConfirmButton: false
        });
    } else {
        alert(`${title}: ${message}`);
    }
}

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

// ==================== NAVIGATION FUNCTIONS ====================
function toggleMenu(event) {
    event.stopPropagation();
    
    elements.nav.classList.toggle("nav-hidden");
    elements.nav.classList.toggle("nav-open");
    elements.menuToggle.classList.toggle("menuToggle-move");
    
    if (elements.navtop) elements.navtop.classList.toggle("navtop-move");
    if (elements.topNavbar) elements.topNavbar.classList.toggle("navtopbar-move");
    
    elements.dashCards.classList.toggle("dashCards-move");
    elements.monitoringSection.classList.toggle("monitoring-move");
    elements.controlSection.classList.toggle("control-move");
    elements.logSection.classList.toggle("log-move");
    if (elements.dropdown) elements.dropdown.classList.toggle("userDropdown-move");
}

function handleDocumentClick(event) {
    const screenWidth = window.innerWidth;
    if (screenWidth < 769) {
        if (!elements.nav.contains(event.target) && !elements.menuToggle.contains(event.target)) {
            elements.nav.classList.add("nav-hidden");
            elements.nav.classList.remove("nav-open");
            elements.menuToggle.classList.remove("menuToggle-move");
            
            if (elements.topNavbar) elements.topNavbar.classList.remove("navtopbar-move");
            if (elements.navtop) elements.navtop.classList.remove("navtop-move");
            
            elements.dashCards.classList.remove("dashCards-move");
            elements.monitoringSection.classList.remove("monitoring-move");
            elements.controlSection.classList.remove("control-move");
            elements.logSection.classList.remove("log-move");
        }
    }
}

function updateNavVisibility() {
    const sidebar = document.getElementById("sidebar");
    const topNavbar = document.getElementById("topNavbar");
    
    if (window.innerWidth > 768) {
        if (sidebar) {
            sidebar.classList.remove("active");
            sidebar.style.transform = "translateX(-100%)";
        }
        if (topNavbar) topNavbar.classList.remove("navtopbar-move");
    } else {
        if (sidebar) sidebar.style.transform = "";
    }
}

// ==================== THEME FUNCTIONS ====================
function initializeTheme() {
    const body = document.body;
    const icon = elements.switchBtn?.querySelector("i");
    
    if (localStorage.getItem("theme") === "dark") {
        body.setAttribute("data-theme", "dark");
        if (icon) {
            icon.classList.remove("fa-moon");
            icon.classList.add("fa-sun");
        }
    } else {
        body.setAttribute("data-theme", "light");
        if (icon) {
            icon.classList.remove("fa-sun");
            icon.classList.add("fa-moon");
        }
    }
}

function toggleTheme() {
    const body = document.body;
    const icon = elements.switchBtn.querySelector("i");
    
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
}

// ==================== PC ITEM FUNCTIONS ====================
function handlePcItemClick(event) {
    if (event.target.closest(".pc-controls") || event.target.closest(".pc-checkbox")) return;
    
    const controls = this.querySelector(".pc-controls");
    if (controls) {
        controls.style.display = controls.style.display === "flex" ? "none" : "flex";
    }
}

function handleSelectAll() {
    const section = document.getElementById("control-section");
    if (!section) return;
    
    const checkboxes = section.querySelectorAll(".pc-checkbox");
    if (checkboxes.length === 0) return;
    
    const allSelected = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(cb => {
        cb.checked = !allSelected;
        const pcItem = cb.closest(".pc-item");
        const pcControls = pcItem.querySelector(".pc-controls");
        
        if (!allSelected) {
            pcItem.classList.add("selected");
            if (pcControls) pcControls.style.display = "flex";
        } else {
            pcItem.classList.remove("selected");
            if (pcControls) pcControls.style.display = "none";
        }
    });
}

// ==================== SECTION SWITCHING ====================
function initializeSectionSwitching() {
    const dashboardLink = document.querySelector("a[href='#dashboard']");
    const monitoringLink = document.querySelector("a[href='#monitoring-section']");
    const controlLink = document.querySelector("a[href='#control-section']");
    const logsLink = document.querySelector("a[href='#logs-section']");
    
    if (dashboardLink) {
        dashboardLink.addEventListener("click", (e) => {
            e.preventDefault();
            showSection("dashboard");
        });
    }
    
    if (monitoringLink) {
        monitoringLink.addEventListener("click", (e) => {
            e.preventDefault();
            showSection("monitoring");
        });
    }
    
    if (controlLink) {
        controlLink.addEventListener("click", (e) => {
            e.preventDefault();
            showSection("control");
        });
    }
    
    if (logsLink) {
        logsLink.addEventListener("click", (e) => {
            e.preventDefault();
            showSection("logs");
        });
    }
    
    showSection("dashboard");
}

function showSection(section) {
    if (!elements.dashCards || !elements.monitoringSection || !elements.controlSection || !elements.logSection) return;
    
    if (section === "dashboard") {
        elements.dashCards.style.display = "block";
        elements.monitoringSection.style.display = "none";
        elements.controlSection.style.display = "none";
        elements.logSection.style.display = "none";
    } else if (section === "monitoring") {
        elements.dashCards.style.display = "none";
        elements.monitoringSection.style.display = "block";
        elements.controlSection.style.display = "none";
        elements.logSection.style.display = "none";
    } else if (section === "control") {
        elements.dashCards.style.display = "none";
        elements.monitoringSection.style.display = "none";
        elements.controlSection.style.display = "block";
        elements.logSection.style.display = "none";
    } else if (section === "logs") {
        elements.dashCards.style.display = "none";
        elements.monitoringSection.style.display = "none";
        elements.controlSection.style.display = "none";
        elements.logSection.style.display = "block";
    }
}

// ==================== LOGS FUNCTIONS ====================
function initializeLogsFiltering() {
    const logSearch = document.getElementById("logSearch");
    const logFilter = document.getElementById("logFilter");
    const logsTable = document.getElementById("logsTable");
    
    if (!logsTable) return;
    
    function filterLogs() {
        let searchQuery = logSearch?.value.toLowerCase().replace(/\s+/g, "") || "";
        let filterType = logFilter?.value.toLowerCase() || "all";
        
        Array.from(logsTable.getElementsByTagName("tr")).forEach(row => {
            let logText = row.innerText.toLowerCase().replace(/\s+/g, "");
            let actionText = row.cells[2]?.innerText.toLowerCase() || "";
            let matchesSearch = logText.includes(searchQuery);
            let matchesFilter = filterType === "all" || actionText.includes(filterType);
            
            row.style.display = matchesSearch && matchesFilter ? "" : "none";
        });
    }
    
    if (logSearch) logSearch.addEventListener("input", filterLogs);
    if (logFilter) logFilter.addEventListener("change", filterLogs);
}

function initializePagination() {
    const rowsPerPage = 10;
    let currentPage = 1;
    
    const tableBody = document.querySelector('#logsTable');
    if (!tableBody) return;
    
    const allRows = Array.from(tableBody.querySelectorAll('tr'));
    if (allRows.length === 0 || (allRows.length === 1 && allRows[0].cells.length === 1)) return;
    
    const filterDropdown = document.querySelector('#logFilter');
    
    const logsTableDiv = document.querySelector('.logsTable');
    if (!logsTableDiv) return;
    
    let paginationContainer = document.querySelector('.pagination-container');
    if (!paginationContainer) {
        paginationContainer = document.createElement('div');
        paginationContainer.classList.add('pagination-container', 'mt-4', 'text-center');
        logsTableDiv.appendChild(paginationContainer);
    }
    
    function showPage(page, rows) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.forEach((row, index) => {
            row.style.display = (index >= start && index < end) ? '' : 'none';
        });
    }
    
    function refreshPagination(filteredRows) {
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        paginationContainer.innerHTML = '';
        if (totalPages <= 1) return;
        
        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.classList.add('px-3', 'py-1', 'm-1', 'border', 'rounded', 'bg-gray-200', 'hover:bg-gray-300');
            if (i === currentPage) btn.classList.add('bg-gray-400');
            btn.addEventListener('click', () => {
                currentPage = i;
                showPage(currentPage, filteredRows);
                
                // Update active state
                document.querySelectorAll('.pagination-container button').forEach(b => {
                    b.classList.remove('bg-gray-400');
                });
                btn.classList.add('bg-gray-400');
            });
            paginationContainer.appendChild(btn);
        }
        showPage(currentPage, filteredRows);
    }
    
    refreshPagination(allRows);
    
    if (filterDropdown) {
        filterDropdown.addEventListener('change', () => {
            currentPage = 1;
            const filterValue = filterDropdown.value.toLowerCase();
            const filteredRows = filterValue === 'all' ? allRows : 
                allRows.filter(row => {
                    const actionText = row.children[2]?.innerText.toLowerCase() || '';
                    return actionText.includes(filterValue);
                });
            refreshPagination(filteredRows);
        });
    }
    
    const searchInput = document.querySelector('#logSearch');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const keyword = searchInput.value.toLowerCase();
            const filterValue = filterDropdown?.value.toLowerCase() || 'all';
            
            const filtered = allRows.filter(row => {
                const rowText = row.textContent.toLowerCase();
                const actionText = row.children[2]?.innerText.toLowerCase() || '';
                const matchesFilter = filterValue === 'all' || actionText.includes(filterValue);
                return rowText.includes(keyword) && matchesFilter;
            });
            
            currentPage = 1;
            refreshPagination(filtered);
        });
    }
}

// ==================== DEVICE STATUS FUNCTIONS ====================
function startPeriodicUpdates() {
    fetchDeviceCounts();
    setInterval(fetchDeviceCounts, 5000);
    
    updateDeviceStatuses();
    setInterval(updateDeviceStatuses, 10000);
}

function fetchDeviceCounts() {
    fetch('/pcs/device-counts')
        .then(response => response.json())
        .then(data => {
            document.getElementById('connectedDevices').innerText = data.connected_devices;
            document.getElementById('onlineDevices').innerText = data.online_devices;
            document.getElementById('totalDevices').innerText = data.total_devices;
        })
        .catch(error => console.error('Error fetching device counts:', error));
}

function updateDeviceStatuses() {
    fetch('/pcs/update-status')
        .then(() => fetch('/pcs/get-status'))
        .then(res => res.json())
        .then(data => {
            data.forEach(device => {
                const statusElement = document.querySelector(`.pc-status[data-ip="${device.ip_address}"]`);
                if (statusElement) {
                    statusElement.textContent = `Status: ${device.device_status}`;
                }
            });
        })
        .catch(err => {
            console.error('Status update failed:', err);
        });
}

// ==================== CONTROL BUTTONS ====================
function initializeControlButtons() {
    document.querySelectorAll('.shutdown, .restart, .lock').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const action = this.classList.contains('shutdown') ? 'shutdown' :
                          this.classList.contains('restart') ? 'restart' : 'lock';
            
            const selectedCheckboxes = document.querySelectorAll('.pc-checkbox:checked');
            
            if (selectedCheckboxes.length > 0) {
                selectedCheckboxes.forEach(cb => {
                    const ip = cb.dataset.ip;
                    sendPcAction(ip, action);
                });
            } else {
                const ip = this.dataset.ip;
                sendPcAction(ip, action);
            }
        });
    });
}

function sendPcAction(ip, action) {
    fetch('/pcs/control', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ ip, action })
    })
        .then(response => response.json())
        .then(data => {
            console.log(`${ip} - ${data.message}`);
            showAlert('info', `${ip}`, data.message);
        })
        .catch(error => console.error('Error:', error));
}

// ==================== LOCK TIMER FUNCTIONS ====================
function initializeLockTimerButtons() {
    document.querySelectorAll('.lock-timer-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const ip = this.getAttribute('data-ip');
            if (elements.lockTimerPcIp) {
                elements.lockTimerPcIp.value = ip;
            }
            
            if (elements.lockTimerHours) elements.lockTimerHours.value = '';
            if (elements.lockTimerMinutes) elements.lockTimerMinutes.value = '';
            if (elements.lockTimerSeconds) elements.lockTimerSeconds.value = '';
            
            // Show the modal
            if (window.lockTimerModal) {
                window.lockTimerModal.show();
            } else {
                // Fallback if Bootstrap modal isn't initialized
                const modalEl = document.getElementById('lockTimerModal');
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            }
        });
    });
}

function handleMultiLockTimer() {
    selectedIps = Array.from(document.querySelectorAll('.pc-checkbox:checked'))
        .map(checkbox => checkbox.dataset.ip);
    
    if (selectedIps.length === 0) {
        showAlert('info', 'No PCs Selected', 'Please select at least one PC.');
        return;
    }
    
    multiMode = true;
    if (elements.lockTimerPcIp) {
        elements.lockTimerPcIp.value = selectedIps[0]; // Just for form validation
    }
    if (elements.lockTimerHours) elements.lockTimerHours.value = '';
    if (elements.lockTimerMinutes) elements.lockTimerMinutes.value = '';
    if (elements.lockTimerSeconds) elements.lockTimerSeconds.value = '';
    
    // Show the modal
    if (window.lockTimerModal) {
        window.lockTimerModal.show();
    } else {
        const modalEl = document.getElementById('lockTimerModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }
}

function startCountdown(ip, duration) {
    const displayId = `countdown-${ip.replace(/\./g, '-')}`;
    const display = document.getElementById(displayId);
    if (!display) return;
    
    if (timers[ip]) clearInterval(timers[ip]);
    
    let remaining = duration;
    
    function updateDisplay() {
        const h = String(Math.floor(remaining / 3600)).padStart(2, '0');
        const m = String(Math.floor((remaining % 3600) / 60)).padStart(2, '0');
        const s = String(remaining % 60).padStart(2, '0');
        display.textContent = `${h}:${m}:${s}`;
        
        if (remaining <= 0) {
            clearInterval(timers[ip]);
            display.textContent = "Locked";
            setTimeout(() => {
                display.textContent = "";
            }, 5000);
        }
        remaining--;
    }
    
    updateDisplay();
    timers[ip] = setInterval(updateDisplay, 1000);
}

function handleLockTimerSubmit(e) {
    e.preventDefault();
    
    const ip = elements.lockTimerPcIp?.value;
    const targetIps = multiMode ? selectedIps : [ip];
    const hours = parseInt(elements.lockTimerHours?.value) || 0;
    const minutes = parseInt(elements.lockTimerMinutes?.value) || 0;
    const seconds = parseInt(elements.lockTimerSeconds?.value) || 0;
    
    if (hours < 0 || minutes < 0 || seconds < 0) {
        showAlert('warning', 'Invalid Time', 'Time values cannot be negative.');
        return;
    }
    
    if (minutes > 59 || seconds > 59) {
        showAlert('warning', 'Invalid Time', 'Minutes and seconds must be less than 60.');
        return;
    }
    
    const totalSeconds = (hours * 3600) + (minutes * 60) + seconds;
    
    if (totalSeconds <= 0) {
        showAlert('warning', 'Invalid Timer', 'Please set a time greater than zero.');
        return;
    }
    
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Setting...';
    submitBtn.disabled = true;
    
    Promise.all(targetIps.map(ipAddr => {
        return fetch(`http://${ipAddr}:5000/set-timer`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ ip: ipAddr, hours, minutes, seconds, action: 'lock' })
        }).catch(err => {
            console.error(`Failed to connect to ${ipAddr}:`, err);
            throw new Error(`Cannot connect to ${ipAddr}`);
        });
    }))
        .then(async responses => {
            for (let i = 0; i < responses.length; i++) {
                const res = responses[i];
                const ipAddr = targetIps[i];
                
                if (!res.ok) {
                    const text = await res.text();
                    throw new Error(`Failed for ${ipAddr}: ${text}`);
                }
                
                startCountdown(ipAddr, totalSeconds);
            }
            
            // Hide modal
            if (window.lockTimerModal) {
                window.lockTimerModal.hide();
            } else {
                const modalEl = document.getElementById('lockTimerModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
            
            showAlert('success', 'Timer Set!', 'The lock timer has been started for all selected PCs.', 2000);
        })
        .catch(err => {
            console.error('Error:', err);
            showAlert('error', 'Error', err.message || 'Something went wrong while setting the timer.');
        })
        .finally(() => {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
            multiMode = false;
            selectedIps = [];
        });
}

function initializeCountdowns() {
    // This would need server-side state to restore properly
}

// ==================== REQUEST FUNCTIONS ====================
function initializeRequestButtons() {
    document.querySelectorAll('.send-request').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            selectedIp = this.dataset.ip;
            if (elements.modalPcName) {
                elements.modalPcName.innerText = this.dataset.name;
            }
            
            // Clear any previous multi-select data
            if (elements.requestModal) {
                elements.requestModal.dataset.ips = '';
            }
            
            if (window.requestModal) {
                window.requestModal.show();
            } else {
                const modalEl = document.getElementById('requestModal');
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            }
        });
    });
}

function handleMultiFileRequest() {
    const selectedCheckboxes = document.querySelectorAll('.pc-checkbox:checked');
    
    if (selectedCheckboxes.length === 0) {
        showAlert('info', 'No PCs Selected', 'Please select at least one PC.');
        return;
    }
    
    const ips = Array.from(selectedCheckboxes).map(cb => cb.dataset.ip);
    if (elements.modalPcName) {
        elements.modalPcName.innerText = `${ips.length} PC(s) selected`;
    }
    if (elements.requestModal) {
        elements.requestModal.dataset.ips = JSON.stringify(ips);
    }
    
    if (window.requestModal) {
        window.requestModal.show();
    } else {
        const modalEl = document.getElementById('requestModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }
}

function sendRequest() {
    let message = elements.requestMessage?.value || '';
    const ipsData = elements.requestModal?.dataset.ips;
    const ips = ipsData ? JSON.parse(ipsData) : [selectedIp];
    
    if (!ips || ips.length === 0) {
        showAlert('warning', 'No Target', 'Please select at least one PC.');
        return;
    }
    
    fetch('/send-request', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ ips: ips, message: message })
    })
        .then(res => {
            if (!res.ok) return res.text().then(text => { throw new Error(text); });
            return res.json();
        })
        .then(data => {
            showAlert('success', 'Success', data.message);
            
            // Hide modal
            if (window.requestModal) {
                window.requestModal.hide();
            } else {
                const modalEl = document.getElementById('requestModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
            
            if (elements.requestMessage) elements.requestMessage.value = '';
            if (elements.requestModal) elements.requestModal.dataset.ips = '';
        })
        .catch(err => {
            console.error(err);
            showAlert('error', 'Error', err.message || 'Failed to send request.');
        });
}

// ==================== FILE UPLOAD FUNCTIONS ====================
function initializeFileUploadForms() {
    document.querySelectorAll(".file-upload-form").forEach(form => {
        const fileInput = form.querySelector("input[type='file']");
        if (!fileInput) return;
        
        // Store the original file input display state
        fileInput.setAttribute('data-original-display', fileInput.style.display);
        
        fileInput.addEventListener("change", function(e) {
            e.stopPropagation();
            handleSingleFileUpload(this);
        });
    });
}

function handleSingleFileUpload(fileInput) {
    const file = fileInput.files[0];
    if (!file) return;
    
    const form = fileInput.closest("form");
    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();
    
    const progressContainer = form.querySelector(".progress-container");
    const progressBar = form.querySelector(".progress-bar");
    const pcControls = form.closest(".pc-controls");
    const buttons = pcControls.querySelectorAll("button, input[type='file']");
    const fileTransferBtn = form.querySelector('.file-transfer');
    
    xhr.open("POST", form.action, true);
    xhr.setRequestHeader("X-CSRF-TOKEN", getCsrfToken());
    
    // Hide all buttons and file input to prevent flickering
    buttons.forEach(btn => {
        if (btn.type !== 'file') {
            btn.style.display = "none";
        }
    });
    // Hide the file input specifically
    fileInput.style.display = "none";
    
    // Show progress bar
    if (progressContainer) {
        progressContainer.style.display = "block";
        progressBar.style.width = "0%";
        progressBar.textContent = "0%";
    }
    
    xhr.upload.onprogress = function(event) {
        if (event.lengthComputable && progressBar) {
            let percent = (event.loaded / event.total) * 100;
            progressBar.style.width = percent + "%";
            progressBar.textContent = Math.round(percent) + "%";
        }
    };
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Success
            if (progressBar) {
                progressBar.style.width = "100%";
                progressBar.textContent = "Upload Complete!";
            }
            
            setTimeout(() => {
                // Hide progress container
                if (progressContainer) progressContainer.style.display = "none";
                if (progressBar) progressBar.style.width = "0%";
                
                // Show only the file transfer button (icon), hide the file input completely
                buttons.forEach(btn => {
                    if (btn.classList.contains('file-transfer')) {
                        btn.style.display = "inline-block";
                    } else if (btn.type !== 'file') {
                        btn.style.display = "inline-block";
                    }
                });
                
                // File input remains hidden - this is key!
                fileInput.style.display = "none";
                
                // Reset the file input so the same file can be uploaded again if needed
                fileInput.value = '';
                
            }, 2000);
        } else {
            // Failed
            if (progressBar) {
                progressBar.style.width = "0%";
                progressBar.textContent = "Upload Failed!";
            }
            
            setTimeout(() => {
                if (progressContainer) progressContainer.style.display = "none";
                
                // Show all buttons again including file input on failure
                buttons.forEach(btn => btn.style.display = "inline-block");
                fileInput.style.display = "inline-block";
                
            }, 2000);
        }
    };
    
    xhr.onerror = function() {
        if (progressBar) {
            progressBar.style.width = "0%";
            progressBar.textContent = "Upload Failed!";
        }
        
        setTimeout(() => {
            if (progressContainer) progressContainer.style.display = "none";
            buttons.forEach(btn => btn.style.display = "inline-block");
            fileInput.style.display = "inline-block";
        }, 2000);
    };
    
    xhr.send(formData);
}

function handleGlobalFileUpload() {
    const file = elements.globalFileInput.files[0];
    if (!file) return;
    
    const checkedCheckboxes = document.querySelectorAll(".pc-checkbox:checked");
    if (checkedCheckboxes.length === 0) {
        showAlert('info', 'No PCs Selected', 'Please select at least one PC to upload to.');
        elements.globalFileInput.value = '';
        return;
    }
    
    let completed = 0;
    let failed = 0;
    const totalPCs = checkedCheckboxes.length;
    
    checkedCheckboxes.forEach(checkbox => {
        const ip = checkbox.dataset.ip;
        const fileInput = document.getElementById(`fileInput-${ip}`);
        if (!fileInput) return;
        
        const form = fileInput.closest("form");
        const progressContainer = form.querySelector(".progress-container");
        const progressBar = form.querySelector(".progress-bar");
        const pcControls = form.closest(".pc-controls");
        const buttons = pcControls.querySelectorAll("button, input[type='file']");
        const fileTransferBtn = form.querySelector('.file-transfer');
        
        const fileClone = new File([file], file.name, { type: file.type });
        const formData = new FormData(form);
        formData.set("file", fileClone);
        
        const xhr = new XMLHttpRequest();
        xhr.open("POST", form.action, true);
        xhr.setRequestHeader("X-CSRF-TOKEN", getCsrfToken());
        
        // Hide all buttons and file inputs
        buttons.forEach(btn => {
            if (btn.type !== 'file') {
                btn.style.display = "none";
            }
        });
        fileInput.style.display = "none";
        
        if (progressContainer) {
            progressContainer.style.display = "block";
            progressBar.style.width = "0%";
            progressBar.textContent = "0%";
        }
        
        xhr.upload.onprogress = function(event) {
            if (event.lengthComputable && progressBar) {
                let percent = (event.loaded / event.total) * 100;
                progressBar.style.width = percent + "%";
                progressBar.textContent = Math.round(percent) + "%";
            }
        };
        
        xhr.onload = function() {
            completed++;
            if (xhr.status === 200) {
                if (progressBar) {
                    progressBar.style.width = "100%";
                    progressBar.textContent = "Complete!";
                }
            } else {
                failed++;
                if (progressBar) {
                    progressBar.style.width = "0%";
                    progressBar.textContent = "Failed!";
                }
            }
            
            // Reset after all uploads complete
            if (completed === totalPCs) {
                setTimeout(() => {
                    checkedCheckboxes.forEach(cb => {
                        const ip = cb.dataset.ip;
                        const input = document.getElementById(`fileInput-${ip}`);
                        if (input) {
                            const form = input.closest("form");
                            const progressContainer = form.querySelector(".progress-container");
                            const progressBar = form.querySelector(".progress-bar");
                            const pcControls = form.closest(".pc-controls");
                            const buttons = pcControls.querySelectorAll("button, input[type='file']");
                            
                            if (progressContainer) progressContainer.style.display = "none";
                            if (progressBar) progressBar.style.width = "0%";
                            
                            // Show only icons, hide file inputs
                            buttons.forEach(btn => {
                                if (btn.classList.contains('file-transfer') || 
                                    btn.classList.contains('shutdown') ||
                                    btn.classList.contains('restart') ||
                                    btn.classList.contains('lock') ||
                                    btn.classList.contains('lock-timer-btn') ||
                                    btn.classList.contains('send-request') ||
                                    btn.classList.contains('view-processes')) {
                                    btn.style.display = "inline-block";
                                }
                            });
                            
                            // File input remains hidden
                            input.style.display = "none";
                            input.value = '';
                        }
                    });
                    
                    if (failed > 0) {
                        showAlert('warning', 'Upload Complete', `Uploaded to ${completed - failed} PCs, failed on ${failed} PCs.`);
                    } else {
                        showAlert('success', 'Upload Complete', `Successfully uploaded to ${completed} PCs.`);
                    }
                }, 2000);
            }
        };
        
        xhr.onerror = function() {
            completed++;
            failed++;
            if (progressBar) {
                progressBar.style.width = "0%";
                progressBar.textContent = "Failed!";
            }
        };
        
        xhr.send(formData);
    });
    
    elements.globalFileInput.value = "";
}

// ==================== PROCESS VIEWER ====================
function initializeProcessViewer() {
    document.querySelectorAll('.view-processes').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            let ip = this.dataset.ip;
            if (elements.processModal) {
                elements.processModal.style.display = "flex";
            }
            if (elements.processModalContent) {
                elements.processModalContent.innerHTML = "<p class='text-center'>Connecting...</p>";
            }
            
            let socket = io(`http://${ip}:5000`, { transports: ["websocket", "polling"] });
            
            socket.on('update_processes', function(data) {
                if (data.processes && data.processes.length > 0) {
                    data.processes.sort((a, b) => b.cpu - a.cpu);
                    
                    let html = `
                        <div class="p-4 bg-gray-100 rounded-lg shadow-md mb-4" id="SysPerformance">
                            <div class="h3-container"><h3 class="text-lg font-bold mb-2">System Performance</h3></div>
                            <div class="performance-container">
                                <p><strong>CPU Usage:</strong> <span class="${data.cpu_usage > 70 ? 'text-red-600' : 'text-green-600'}">${data.cpu_usage}%</span></p>
                                <p><strong>Memory Usage:</strong> <span class="${data.memory_usage > 80 ? 'text-red-600' : 'text-blue-600'}">${data.memory_usage}%</span></p>
                                <p><strong>Network Usage:</strong> ${data.network_usage}</p>
                            </div>
                        </div>
                        <table class="w-full text-sm border-collapse">
                            <thead class="sticky top-0 bg-gray-300">
                                <tr>
                                    <th class="border p-2 text-left">Process Name</th>
                                    <th class="border p-2 text-left">PID</th>
                                    <th class="border p-2 text-left">CPU (%)</th>
                                    <th class="border p-2 text-left">Memory (MB)</th>
                                    <th class="border p-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                    `;
                    
                    data.processes.forEach(proc => {
                        html += `
                            <tr class="hover:bg-gray-100">
                                <td class="border p-2">${proc.name || 'Unknown'}</td>
                                <td class="border p-2">${proc.pid}</td>
                                <td class="border p-2 font-bold ${proc.cpu > 50 ? 'text-red-600' : 'text-green-600'}">${proc.cpu}%</td>
                                <td class="border p-2 ${proc.memory > 500 ? 'text-red-600' : 'text-blue-600'}">${proc.memory}MB</td>
                                <td class="border p-2">
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700 end-task" 
                                        data-ip="${ip}" data-pid="${proc.pid}">
                                        End Task
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    html += `
                            </tbody>
                        </table>
                    `;
                    
                    elements.processModalContent.innerHTML = html;
                    
                    document.querySelectorAll('.end-task').forEach(btn => {
                        btn.addEventListener('click', function() {
                            let pid = this.dataset.pid;
                            let ip = this.dataset.ip;
                            endTask(ip, pid);
                        });
                    });
                } else {
                    elements.processModalContent.innerHTML = "<p class='text-center'><strong>No active processes found</strong></p>";
                }
            });
            
            socket.on("connect_error", () => {
                elements.processModalContent.innerHTML = "<p class='text-center text-red-500'><strong>Failed to connect to PC</strong></p>";
            });
        });
    });
    
    if (elements.closeModalBtn) {
        elements.closeModalBtn.addEventListener('click', function() {
            if (elements.processModal) elements.processModal.style.display = "none";
        });
    }
    
    if (elements.processModal) {
        elements.processModal.addEventListener('click', function(event) {
            if (event.target === elements.processModal) {
                elements.processModal.style.display = "none";
            }
        });
    }
}

function endTask(ip, pid) {
    if (confirm(`Are you sure you want to end process ${pid}?`)) {
        fetch(`http://${ip}:5000/kill-process`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ pid: pid })
        })
            .then(response => response.json())
            .then(data => {
                showAlert('info', 'Process', data.message || data.error || 'Process terminated');
            })
            .catch(error => {
                console.error("Error:", error);
                showAlert('error', 'Error', 'Failed to terminate process.');
            });
    }
}

// ==================== ADD PC FUNCTIONS ====================
function fetchNextPort() {
    console.log('Fetching next port...');
    
    // Get the base URL from the current page
    const baseUrl = window.location.origin;
    
    fetch(`${baseUrl}/next-port`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Error response body:', text);
                throw new Error(`HTTP error ${response.status}`);
            });
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Next port data:', data);
        if (elements.pcPortInput) {
            elements.pcPortInput.value = data.next_port;
        }
    })
    .catch(error => {
        console.error("Failed to fetch next port:", error);
        
        // Fallback to calculating from DOM
        if (elements.pcPortInput) {
            const pcItems = document.querySelectorAll('.pc-item');
            let maxPort = 6079;
            
            pcItems.forEach(item => {
                const portElement = item.querySelector('.pc-info p:nth-child(2)');
                if (portElement) {
                    const portText = portElement.textContent;
                    const port = parseInt(portText.replace('Port: ', ''));
                    if (!isNaN(port) && port > maxPort) {
                        maxPort = port;
                    }
                }
            });
            
            elements.pcPortInput.value = maxPort + 1;
            console.log('Using fallback port:', maxPort + 1);
        }
    });
}

function addPc() {
    let ip = elements.pcIpInput?.value;
    let port = elements.pcPortInput?.value;
    
    if (!ip || !port) {
        showAlert('warning', 'Missing Info', 'Please enter both IP address and port.');
        return;
    }
    
    fetch('/add-pc', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ ip_address: ip, port: port })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', 'Success', 'PC Added Successfully!');
                
                // Hide modal
                if (window.addPcModal) {
                    window.addPcModal.hide();
                } else {
                    const modalEl = document.getElementById("addPcModal");
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                }
                
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showAlert('error', 'Error', 'Error adding PC: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            showAlert('error', 'Error', 'Failed to add PC.');
        });
}

// ==================== CHAT FUNCTIONS ====================
function toggleChatModal() {
    if (elements.chatModal) {
        if (elements.chatModal.style.display === "none" || elements.chatModal.style.display === "") {
            elements.chatModal.style.display = "block";
        } else {
            elements.chatModal.style.display = "none";
        }
    }
}

// ==================== GRID GAP ADJUSTMENT ====================
function adjustGap() {
    const pcItems = document.querySelectorAll(".pc-item").length;
    let newGap = 120;
    
    if (pcItems > 10) {
        newGap = Math.max(10, 120 * Math.pow(0.1, pcItems - 10));
    }
    
    document.documentElement.style.setProperty("--dynamic-gap", `${newGap}px`);
}

// Call on load and observe changes
adjustGap();
const observer = new MutationObserver(adjustGap);
const pcGrid = document.querySelector(".pc-grid");
if (pcGrid) observer.observe(pcGrid, { childList: true });
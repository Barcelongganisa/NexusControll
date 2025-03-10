<title>NexusControl Admin</title>
<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6" id="dashCards">
        <h2>Dashboard</h2>
        <div class="dashboard-cards">
            <div class="card">
                <h3>Connected Device</h3>
                <p>5</p>
            </div>
            <div class="card">
                <h3>Online Devices</h3>
                <p>3</p>
            </div>
            <div class="card">
                <h3>Total Devices</h3>
                <p>10</p>
            </div>
            <div class="alert-card">
                <h3>Alerts</h3>
                <p>2 Critical Alerts</p>
            </div>
        </div>
    </div>

   <!-- Monitoring Section -->
<div class="monitoring-container max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10" id="monitoring-section">
    <h2 class="text-xl font-semibold mb-4">Monitoring</h2>
    <div class="pc-grid" id="connected-pcs">
        <!-- This will be populated dynamically -->
        <div class="loading-message text-center p-4">Loading connected devices...</div>
    </div>
</div>

<!-- Modal Popup for Monitoring-->
<div id="pcModal" class="modal">    
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="pcTitle">PC Name: </h2>
        <img id="pcImage" src="" alt="PC Image" class="modal-img" onclick="sendClick(event)">

        <div class="modal-options">
            <button id="chatToggle" onclick="toggleChatModal()"><i class="fas fa-comment"></i></button>
        </div>
    </div>
</div>

<!-- Chat Box (Initially Hidden) -->
<div id="chatModal" class="chat-modal" style="display: none;">
    <div class="chat-modal-content">
        <span class="close-btn" onclick="closeChatModal()">&times;</span>
        <h2>Chat</h2>
        <div id="chatMessages"></div>
        <label for="fileInput" class="custom-file-icon">
            <i class="fas fa-upload"></i>
        </label>
        <input type="file" id="fileInput" class="custom-file-input" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt">
        <input type="text" id="chatInput" placeholder="Type a message..." onkeypress="sendMessage(event)">
        <button id="sendButton" onclick="sendMessageBtn()"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.1/socket.io.js"></script>
{{-- <script>
    // Keep track of the currently selected PC
    let selectedPcId = null;
    
    // Modal functions
    function openModal(pcId, pcName, imageSrc) {
        selectedPcId = pcId;
        document.getElementById("pcTitle").textContent = "PC Name: " + pcName;
        document.getElementById("pcImage").src = imageSrc || "{{ asset('images/pc.png') }}";
        document.getElementById("pcModal").style.display = "block";
    }
    
    function closeModal() {
        selectedPcId = null;
        document.getElementById("pcModal").style.display = "none";
    }

    function toggleChatModal() {
        const chatModal = document.getElementById("chatModal");
        chatModal.style.display = chatModal.style.display === "none" ? "block" : "none";
    }

    function closeChatModal() {
        document.getElementById("chatModal").style.display = "none";
    }

    function sendMessage(event) {
        if (event.key === "Enter") {
            const input = document.getElementById("chatInput");
            const message = input.value.trim();
            
            if (message) {
                const messagesDiv = document.getElementById("chatMessages");
                const messageElement = document.createElement("div");
                messageElement.className = "message sent";
                messageElement.textContent = message;
                messagesDiv.appendChild(messageElement);
                
                input.value = "";
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }
        }
    }

    function sendMessageBtn() {
        const input = document.getElementById("chatInput");
        const message = input.value.trim();
        
        if (message) {
            const messagesDiv = document.getElementById("chatMessages");
            const messageElement = document.createElement("div");
            messageElement.className = "message sent";
            messageElement.textContent = message;
            messagesDiv.appendChild(messageElement);
            
            input.value = "";
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const connectedPcsContainer = document.getElementById("connected-pcs");
        
        // Function to render a PC item
        function renderPcItem(pc) {
            const pcDiv = document.createElement("div");
            pcDiv.className = "pc-item";
            pcDiv.setAttribute("data-pc-id", pc.id);
            pcDiv.onclick = () => openModal(pc.id, pc.name, pc.imageUrl);
            
            pcDiv.innerHTML = `
                <img src="{{ asset('images/pc.png') }}" alt="${pc.name}">
                <div class="pc-info">
                    <p>PC Name: ${pc.name}</p>
                    <p>Status: ${pc.status}</p>
                </div>
            `;
            
            return pcDiv;
        }
        
        try {
            // Connect to Socket.IO server
            const socket = io("http://192.168.1.15:3000");
            
            socket.on("connect", () => {
                console.log("✅ Connected to Socket.IO server");
            });
            
            // Initial connected PCs load
            socket.on("initialConnectedPCs", (connectedPCs) => {
                // Clear loading message
                connectedPcsContainer.innerHTML = '';
                
                // If no PCs are connected, show a message
                if (!connectedPCs || connectedPCs.length === 0) {
                    connectedPcsContainer.innerHTML = '<p class="text-center p-4">No PCs currently connected</p>';
                    return;
                }
                
                // Add each connected PC to the grid
                connectedPCs.forEach(pc => {
                    connectedPcsContainer.appendChild(renderPcItem(pc));
                });
            });
            
            // PC connection event
            socket.on("pcConnected", (pc) => {
                // Remove "no PCs" message if it exists
                const noItemsMsg = connectedPcsContainer.querySelector("p.text-center");
                if (noItemsMsg) {
                    connectedPcsContainer.innerHTML = '';
                }
                
                // Check if we already have this PC
                const existingPc = document.querySelector(`.pc-item[data-pc-id="${pc.id}"]`);
                if (!existingPc) {
                    connectedPcsContainer.appendChild(renderPcItem(pc));
                }
            });
            
            // PC disconnection event
            socket.on("pcDisconnected", (pcId) => {
                const pcElement = document.querySelector(`.pc-item[data-pc-id="${pcId}"]`);
                if (pcElement) {
                    pcElement.remove();
                    
                    // If no PCs are left, show the message
                    if (connectedPcsContainer.children.length === 0) {
                        connectedPcsContainer.innerHTML = '<p class="text-center p-4">No PCs currently connected</p>';
                    }
                    
                    // If the modal for this PC is open, close it
                    if (selectedPcId === pcId) {
                        closeModal();
                    }
                }
            });
            
            // Update PC status
            socket.on("pcStatusUpdate", (pc) => {
                const pcElement = document.querySelector(`.pc-item[data-pc-id="${pc.id}"]`);
                if (pcElement) {
                    const statusElement = pcElement.querySelector('.pc-info p:nth-child(2)');
                    if (statusElement) {
                        statusElement.textContent = `Status: ${pc.status}`;
                    }
                }
            });
            
            // Handle screen updates for the currently open modal
            socket.on("updateScreen", (data) => {
                // Only update the image if this is the selected PC or no PC ID was provided
                if (!selectedPcId || data.pcId === selectedPcId) {
                    document.getElementById("pcImage").src = data.imageUrl;
                }
            });
            
            socket.on("connect_error", (error) => {
                console.error("❌ Socket.IO connection error:", error);
                connectedPcsContainer.innerHTML = '<p class="text-center p-4 text-red-500">Error connecting to server</p>';
            });
            
        } catch (error) {
            console.error("❌ Error initializing Socket.IO:", error);
            connectedPcsContainer.innerHTML = '<p class="text-center p-4 text-red-500">Error initializing connection</p>';
        }
    });
</script> --}}


<!-- Control Section -->
<div class="control-container max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10" id="control-section">
    <h2 class="text-xl font-semibold mb-4">Controls</h2>
    <button id="selectAll"><i class="fa-solid fa-check"></i></button>

    <div class="pc-grid">
        @foreach(range(1, 10) as $i)
        <div class="pc-item">
            <img src="{{ asset('images/pc.png') }}" alt="PC {{ $i }}">
            <div class="pc-info">
                <p>PC Name: PC {{ $i }}</p>
                <p>Status: Online</p>
            </div>
            <div class="pc-controls">
                <button class="shutdown" title="Shutdown"><i class="fas fa-power-off"></i></button>
                <button class="restart" title="Restart"><i class="fas fa-sync-alt"></i></button>
                <button class="lock" title="Lock"><i class="fas fa-lock"></i></button>
                <button class="file-transfer" title="File Transfer"><i class="fas fa-file-upload"></i></button>
                <button class="adv-opt" title="Advanced Options"><i class="fas fa-toolbox"></i></button>
            </div>
        </div>
        @endforeach
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const ws = new WebSocket("ws://192.168.1.15:8080");

        ws.onopen = () => console.log("✅ Connected to WebSocket server");
        ws.onclose = () => console.log("🔌 WebSocket disconnected");
        ws.onerror = (error) => console.error("❌ WebSocket error:", error);

        function sendCommand(pcId, command) {
            if (ws.readyState === WebSocket.OPEN) {
                ws.send(JSON.stringify({ pc_id: pcId, command: command }));
                console.log(`📩 Sent command "${command}" to PC ${pcId}`);
            } else {
                console.warn("⚠️ WebSocket not connected!");
            }
        }

        // Check if "selectAll" button exists before adding an event listener
        const selectAllBtn = document.getElementById("selectAll");
        if (selectAllBtn) {
            selectAllBtn.addEventListener("click", () => {
                document.querySelectorAll(".pc-item").forEach((pc, index) => {
                    const pcId = index + 1;
                    sendCommand(pcId, "shutdown"); // Change this if needed
                });
            });
        } else {
            console.error("❌ selectAll button not found!");
        }

        document.querySelectorAll(".pc-item").forEach((pc, index) => {
            const pcId = index + 1;

            // Check if elements exist before attaching event listeners
            pc.querySelector(".shutdown")?.addEventListener("click", () => sendCommand(pcId, "shutdown"));
            pc.querySelector(".restart")?.addEventListener("click", () => sendCommand(pcId, "restart"));
            pc.querySelector(".lock")?.addEventListener("click", () => sendCommand(pcId, "lock"));
            pc.querySelector(".file-transfer")?.addEventListener("click", () => sendCommand(pcId, "file-transfer"));
            pc.querySelector(".adv-opt")?.addEventListener("click", () => sendCommand(pcId, "adv-opt"));
        });
    });
</script>



<!-- Small Modal for Advanced Options -->
<div class="modal fade" id="advOptionsModal" tabindex="-1" aria-labelledby="advOptionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm"> <!-- Small modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="advOptionsLabel">Advanced Options</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Configure advanced settings for this PC.</p>
                <button class="btn btn-primary w-100">Apply Settings</button>
            </div>
        </div>
    </div>
</div>



<!-- Logs Section -->
<div class="logs-container max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10" id="logs-section">
    <h2 class="text-xl font-semibold mb-4">Logs</h2>
    
    <!-- Search and Filter Options -->
    <div class="logs-filters flex justify-between mb-4">
        <input type="text" id="logSearch" class="border p-2 w-1/3" placeholder="Search logs...">
        <select id="logFilter" class="border p-2">
            <option value="all">All</option>
            <option value="shutdown">Shutdown</option>
            <option value="startup">Startup</option>
            <option value="restart">Restart</option>
            <option value="file">File Transfer</option>
        </select>
    </div>

    <!-- Logs Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-left">
                    <th class="p-2 border">Timestamp</th>
                    <th class="p-2 border">PC Name</th>
                    <th class="p-2 border">Action</th>
                    <th class="p-2 border">Status</th>
                </tr>
            </thead>
            <tbody id="logsTable">
                <!-- Example log entries (Dynamically populated) -->
                <tr>
                    <td class="p-2 border">2025-01-22 14:30:05</td>
                    <td class="p-2 border">PC 1</td>
                    <td class="p-2 border">Shutdown</td>
                    <td class="p-2 border text-red-500">Failed</td>
                </tr>
                <tr>
                    <td class="p-2 border">2025-02-22 14:28:10</td>
                    <td class="p-2 border">PC 3</td>
                    <td class="p-2 border">Restart</td>
                    <td class="p-2 border text-green-500">Success</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

    <button 
        class="absolute top-5 left-5 bg-blue-500 text-white px-4 py-2 rounded"
        id="menuToggle">
        ☰
    </button>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>

<title>NexusControl Admin</title>
<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .vnc-container {
            margin-bottom: 20px;
        }

        iframe {
            border: 1px solid #ccc;
            width: 100%;
            height: 815px;
        }
    </style>


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
                <h3>Connected Devices</h3>
                <p id="connectedDevices">{{ $subPcs->count() }}</p>
            </div>
            <div class="card">
                <h3>Online Devices</h3>
                <p id="onlineDevices">{{ $subPcs->where('status', 'online')->count() }}</p>
            </div>
            <div class="card">
                <h3>Total Devices</h3>
                <p id="totalDevices">{{ $subPcs->count() }}</p>
            </div>
        </div>

        <div class="alert-card">
            <h3>Alerts</h3>
            <p>2 Critical Alerts</p>
            <p>PC1 Forced Shutdown</p>
            <p>PC3 downloaded potential risk file</p>
            <p>2 Critical Alerts</p>
            <p>2 Critical Alerts</p>
            <p>2 Critical Alerts</p>
            <p>2 Critical Alerts</p>
        </div>
    </div>
    </div>

    <script>
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

        fetchDeviceCounts(); // Load counts on page load
        setInterval(fetchDeviceCounts, 5000); // Refresh every 5 seconds
    </script>


    <!-- Monitoring Section -->
    <div class="monitoring-container max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10" id="monitoring-section">
    <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Monitoring</h2>
        <button type="button" id="addPcButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPcModal">
            +
        </button>
    </div>
    
        <div class="pc-grid" id="connected-pcs">
            @foreach ($subPcs as $subPc)
                <div class="pc-item" onclick="openModal('{{ $subPc->id }}', '{{ $subPc->vnc_port }}')">
                    <img src="{{ asset('images/pc.png') }}" alt="PC {{ $subPc->ip_address }}">
                    <div class="pc-info">
                        <p>PC Name: {{ $subPc->ip_address}} </p>
                        <p>Port: {{ $subPc->vnc_port }}</p>
                {{-- <p>Status: {{ $subPc->status }}</p> --}}
                        <p class="pc-status" data-ip="{{ $subPc->ip_address }}">
                            Status: {{ $subPc->device_status }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

<!-- Modal for Adding PC -->
<div class="modal fade" id="addPcModal" tabindex="-1" aria-labelledby="addPcModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPcModalLabel">Add a New PC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="pc-ip" class="form-label">IP Address:</label>
                <input type="text" id="pc-ip" class="form-control" placeholder="192.168.x.x">

                <label for="pc-port" class="form-label mt-3">Port:</label>
                <input type="text" id="pc-port" class="form-control" placeholder="6083">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="confirmAddPc">Add</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


    <!-- Modal Popup for Monitoring -->
    <div id="pcModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="pcTitle">PC Name: </h2>
            <div class="vnc-container">
                <iframe id="vnc" src="" frameborder="0"></iframe>
            </div>
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


    <!-- Control Section -->
    <div class="control-container max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10" id="control-section">
        <h2 class="text-xl font-semibold mb-4">Controls</h2>
        <button id="selectAll" title="Select All"><i class="fa-solid fa-check"></i></button>

        <div class="pc-grid" id="control-pcs">
        @foreach($subPcs as $subPc)
            <div class="pc-item">
                <img src="{{ asset('images/pc.png') }}" alt="PC {{ $subPc->ip_address }}">
                <div class="pc-info">
                    <p>PC Name: {{ $subPc->pc_name }}</p>
                    <p>IP Address: {{ $subPc->ip_address }}</p>
                    <p>Port: {{ $subPc->vnc_port }}</p>
                </div>
                    <div class="pc-controls" style="display: none;">
                        <button class="shutdown" data-ip="{{ $subPc->ip_address }}" title="Shutdown"><i class="fas fa-power-off"></i></button>
                        <button class="restart" data-ip="{{ $subPc->ip_address }}" title="Restart"><i class="fas fa-sync-alt"></i></button>
                        <button class="lock" data-ip="{{ $subPc->ip_address }}" title="Lock"><i class="fa-solid fa-lock"></i></button>
                    </div>
            </div>
        @endforeach
    </div>
    <script>
    document.querySelectorAll('.shutdown, .restart, .lock').forEach(button => {
        button.addEventListener('click', function () {
            let ip = this.dataset.ip;
            let action = this.classList.contains('shutdown') ? 'shutdown' :
                this.classList.contains('restart') ? 'restart' : 'lock';

            fetch('/pcs/control', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ ip, action })
            })
                .then(response => response.json())
                .then(data => alert(data.message))
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
    </div>



    <!-- Small Modal for Advanced Options -->
    <div class="modal fade" id="advOptionsModal" tabindex="-1" aria-labelledby="advOptionsLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <!-- Small modal -->
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
        <div class="bg-transparent dark:bg-gray-800 sm:rounded-lg pt-6 pb-6">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-center">
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

    <button class="absolute top-5 left-5 bg-blue-500 text-white px-4 py-2 rounded" id="menuToggle">
        ☰
    </button>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    fetch("http://127.0.0.1:8000/api/device-stats")
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            document.getElementById("connectedDevices").textContent = data.connected;
            document.getElementById("onlineDevices").textContent = data.online;
            document.getElementById("totalDevices").textContent = data.total;
        })
        .catch(error => {
            console.error("Error fetching device stats:", error);
            document.getElementById("connectedDevices").textContent = "Error";
            document.getElementById("onlineDevices").textContent = "Error";
            document.getElementById("totalDevices").textContent = "Error";
        });
});
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.1/socket.io.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
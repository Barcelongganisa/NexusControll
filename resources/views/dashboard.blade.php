<title>NexusControl Admin</title>
<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: `{!! session('success') !!}`,
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: `{!! session('error') !!}`,
                confirmButtonColor: '#d33'
            });
        </script>
    @endif


    <style>
        .vnc-container {
            margin-bottom: 20px;
        }

        iframe {
            border: 1px solid #ccc;
            width: 100%;
            height: 800px;
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

    <button class="absolute top-5 left-5 bg-blue-500 text-white px-4 py-2 rounded" id="menuToggle">
        ☰
    </button>

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

        <!-- Alert Section -->
        <div class="alert-card">
            <h3>Alerts</h3>
            @if ($alerts->count() > 0)
                <p>{{ $alerts->where('severity', 'high')->count() }} Critical Alerts</p>
                @foreach ($alerts as $alert)
                    <p>{{ $alert->pc_name }} - {{ $alert->message }}</p>
                @endforeach
            @else
                <p>No alerts at the moment.</p>
            @endif
        </div>
    </div>

    <script>
        function fetchAlerts() {
            fetch('/fetch-alerts')
                .then(response => response.json())
                .then(alerts => {
                    const alertList = document.getElementById("alertList");
                    alertList.innerHTML = ''; // Clear previous alerts

                    alerts.forEach(alert => {
                        let newAlert = document.createElement("li");
                        newAlert.textContent = `${alert.pc_name}: ${alert.message} (${alert.severity})`;
                        alertList.prepend(newAlert);
                    });
                })
                .catch(error => console.error("Error fetching alerts:", error));
        }

        setInterval(fetchAlerts, 5000); // Fetch alerts every 5 seconds
    </script>



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
            <button type="button" id="addPcButton" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#addPcModal">
                +
            </button>
        </div>

        <div class="pc-grid" id="connected-pcs">
            @foreach ($subPcs as $subPc)
                <div class="pc-item" onclick="openModal('{{ $subPc->ip_address }}', '{{ $subPc->vnc_port }}')">
                    <img src="{{ asset('images/pc.png') }}" alt="PC {{ $subPc->ip_address }}">
                    <div class="pc-info">
                        <p>PC Name: <br>{{ $subPc->ip_address }}</p>
                        <p>Port: {{ $subPc->vnc_port }}</p>
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
                        <p>PC Name: <br>{{ $subPc->ip_address }}</p>
                        <p>Port: {{ $subPc->vnc_port }}</p>
                        <p class="pc-status" data-ip="{{ $subPc->ip_address }}">
                            Status: {{ $subPc->device_status }}
                        </p>
                    </div>
                    <div class="pc-controls" style="display: none;">
                        <button class="shutdown" data-ip="{{ $subPc->ip_address }}" title="Shutdown"><i
                                class="fas fa-power-off"></i></button>
                        <button class="restart" data-ip="{{ $subPc->ip_address }}" title="Restart"><i
                                class="fas fa-sync-alt"></i></button>
                        <button class="lock" data-ip="{{ $subPc->ip_address }}" title="Lock"><i
                                class="fa-solid fa-lock"></i></button>
                        <form action="{{ url('/upload') }}" method="POST" enctype="multipart/form-data"
                            class="file-upload-form">
                            @csrf
                            <input type="hidden" name="sub_pc_id" value="{{ $subPc->ip_address }}">
                            <input type="file" name="file" id="fileInput-{{ $subPc->ip_address }}" required
                                style="display: none;">

                            <button type="button" class="file-transfer" title="File Transfer"
                                onclick="document.getElementById('fileInput-{{ $subPc->ip_address }}').click();">
                                <i class="fas fa-file-upload"></i>
                            </button>

                            <div class="progress-container" id="progress-{{ $subPc->ip_address }}"
                                style="display:none; margin-top: 10px; ">
                                <div class="progress-bar" id="progress-bar-{{ $subPc->ip_address }}" style="width: 100%;">
                                </div>
                            </div>
                        </form>

                        <script>
                            document.querySelectorAll(".file-upload-form").forEach(form => {
                                const fileInput = form.querySelector("input[type='file']");
                                const progressContainer = form.querySelector(".progress-container");
                                const progressBar = form.querySelector(".progress-bar");
                                const pcControls = form.closest(".pc-controls");
                                const buttons = pcControls.querySelectorAll("button, input[type='file']");

                                fileInput.addEventListener("change", function () {
                                    const file = fileInput.files[0];
                                    if (!file) return;

                                    const formData = new FormData(form);
                                    const xhr = new XMLHttpRequest();

                                    xhr.open("POST", "{{ url('/upload') }}", true);
                                    xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

                                    // Hide buttons completely to prevent flickering
                                    buttons.forEach(btn => btn.style.display = "none");

                                    // Show progress bar
                                    progressContainer.style.display = "block";

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

                                                // Restore buttons after upload is complete
                                                buttons.forEach(btn => btn.style.display = "inline-block");

                                                fileInput.style.display = "none"; ileInput.style.display = "none";
                                            }, 2000);
                                        } else {
                                            progressBar.style.width = "0%";
                                            progressBar.textContent = "Upload Failed!";

                                            setTimeout(() => {
                                                progressContainer.style.display = "none";

                                                // Restore buttons even if upload fails
                                                buttons.forEach(btn => btn.style.display = "none");

                                                // Reset file input properly
                                                fileInput.style.display = "none";
                                            }, 2000);
                                        }
                                    };

                                    xhr.send(formData);
                                });
                            });


                        </script>

                        <button class="view-processes" data-ip="{{ $subPc->ip_address }}" title="View Background Processes">
                            <i class="fas fa-tasks"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Process Modal -->
    <div id="process-modal" style="display: none;"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="modal-content">
            <h2 class="text-xl font-bold mb-4">Task Manager - Processes</h2>
            <button id="close-modal" class="absolute top-4 right-4 text-gray-600 hover:text-black">✖</button>
            <div id="process-modal-content" class="overflow-y-auto max-h-[500px]">
                <p class="text-center">Click "View Background Processes" to fetch data.</p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let modal = document.getElementById('process-modal');
            let modalContent = document.getElementById('process-modal-content');
            let closeModalBtn = document.getElementById('close-modal');

            document.querySelectorAll('.view-processes').forEach(button => {
                button.addEventListener('click', function () {
                    let ip = this.dataset.ip;
                    modal.style.display = "flex";
                    modalContent.innerHTML = "<p class='text-center'>Connecting...</p>";

                    // Connect to Socket.IO server
                    let socket = io(`http://${ip}:5000`, {
                        transports: ["websocket", "polling"]
                    });

                    socket.on('update_processes', function (data) {
                        if (data.processes.length > 0) {
                            // Sort processes by CPU usage (highest to lowest)
                            data.processes.sort((a, b) => b.cpu - a.cpu);

                            modalContent.innerHTML = `
            <div class="p-4 bg-gray-100 rounded-lg shadow-md mb-4">
                <h3 class="text-lg font-bold mb-2">System Performance</h3>
                <p><strong>CPU Usage:</strong> <span class="${data.cpu_usage > 70 ? 'text-red-600' : 'text-green-600'}">${data.cpu_usage}%</span></p>
                <p><strong>Memory Usage:</strong> <span class="${data.memory_usage > 80 ? 'text-red-600' : 'text-blue-600'}">${data.memory_usage}%</span></p>
                <p><strong>Network Usage:</strong> ${data.network_usage}</p>
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
                    ${data.processes.map(proc => `
                        <tr class="hover:bg-gray-100">
                            <td class="border p-2">${proc.name}</td>
                            <td class="border p-2">${proc.pid}</td>
                            <td class="border p-2 font-bold ${proc.cpu > 50 ? 'text-red-600' : 'text-green-600'}">${proc.cpu}%</td>
                            <td class="border p-2 ${proc.memory > 500 ? 'text-red-600' : 'text-blue-600'}">${proc.memory}MB</td>
                            <td class="border p-2">
                                <button class="bg-red-500 text-black px-3 py-1 rounded hover:bg-red-700 end-task" 
                                    data-ip="${ip}" data-pid="${proc.pid}">
                                    End Task
                                </button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;

                            // Add event listeners to End Task buttons
                            document.querySelectorAll('.end-task').forEach(btn => {
                                btn.addEventListener('click', function () {
                                    let pid = this.dataset.pid;
                                    let ip = this.dataset.ip;
                                    endTask(ip, pid);
                                });
                            });

                        } else {
                            modalContent.innerHTML = "<p class='text-center'><strong>No active processes found</strong></p>";
                        }
                    });

                    // Handle errors
                    socket.on("connect_error", () => {
                        modalContent.innerHTML = "<p class='text-center text-red-500'><strong>Failed to connect</strong></p>";
                    });
                });
            });

            // Function to send a kill request
            function endTask(ip, pid) {
                if (confirm(`Are you sure you want to end process ${pid}?`)) {
                    fetch(`http://${ip}:5000/kill-process`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            pid: pid
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message || data.error);
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Failed to terminate process.");
                        });
                }
            }

            // Close the modal
            closeModalBtn.addEventListener('click', function () {
                modal.style.display = "none";
            });

            // Close when clicking outside the modal
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script>



    <script>
        document.querySelectorAll('.shutdown, .restart, .lock').forEach(button => {
            button.addEventListener('click', function () {
                let ip = this.dataset.ip;
                let action = this.classList.contains('shutdown') ? 'shutdown' :
                    this.classList.contains('restart') ? 'restart' : 'lock';

                fetch('/pcs/control', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ip,
                        action
                    })
                })
                    .then(response => response.json())
                    .then(data => alert(data.message))
                    .catch(error => console.error('Error:', error));
            });
        });

        document.querySelectorAll('.view-processes').forEach(button => {
            button.addEventListener('click', function () {
                let ip = this.dataset.ip;
                let processListDiv = document.getElementById('process-list-' + ip);
                processListDiv.style.display = 'block';

                fetch('/pcs/processes', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ip
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.processes) {
                            processListDiv.innerHTML = '<ul>' + data.processes.map(proc => `<li>${proc}</li>`).join('') + '</ul>';
                        } else {
                            processListDiv.innerHTML = '<p>No processes found.</p>';
                        }
                    })
                    .catch(error => {
                        processListDiv.innerHTML = '<p>Error fetching processes.</p>';
                        console.error('Error:', error);
                    });
            });
        });
    </script>
    <script>
        document.querySelectorAll('.show-processes').forEach(button => {
            button.addEventListener('click', function () {
                let ip = this.dataset.ip; // Get Sub-PC IP
                let processListDiv = document.getElementById('process-list-' + ip);

                fetch(`http://${ip}:5000/get-processes`) // Flask API on Sub-PC
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            processListDiv.innerHTML = "<strong>Running Processes:</strong><br>" +
                                data.map(proc => `PID: ${proc.pid}, Name: ${proc.name}, CPU: ${proc.cpu}%, Memory: ${proc.memory}MB`).join('<br>');
                            processListDiv.style.display = 'block';
                        } else {
                            processListDiv.innerHTML = "<strong>No active processes found</strong>";
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        processListDiv.innerHTML = "<strong>Failed to fetch processes</strong>";
                    });
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
                    <p>performance of this PC.</p>
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

        <!-- Scrollable Logs Table -->
        <div class="bg-transparent dark:bg-gray-800 sm:rounded-lg pt-6 pb-6">
            <div class="logsTable overflow-y-auto max-h-50 border rounded-lg">
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
                        @if(isset($logs))
                            @foreach($logs as $log)
                                <tr>
                                    <td class="p-2 border">{{ $log->timestamp }}</td>
                                    <td class="p-2 border">{{ $log->pc_name }}</td>
                                    <td class="p-2 border">{{ $log->action }}</td>
                                    <td class="p-2 border {{ $log->status == 'Success' ? 'text-green-500' : 'text-red-500' }}">
                                        {{ $log->status }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="p-2 border text-center">No logs found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JavaScript to Ensure Descending Order -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let table = document.getElementById("logsTable");
            let rows = Array.from(table.getElementsByTagName("tr"));

            // Skip the first row if it contains the "No logs found" message
            if (rows.length > 1) {
                rows.sort((a, b) => {
                    let dateA = new Date(a.cells[0].textContent);
                    let dateB = new Date(b.cells[0].textContent);
                    return dateB - dateA; // Sort descending
                });

                // Append sorted rows back to the table
                rows.forEach(row => table.appendChild(row));
            }
        });
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const connectedDevicesEl = document.getElementById("connectedDevices");
            const onlineDevicesEl = document.getElementById("onlineDevices");
            const totalDevicesEl = document.getElementById("totalDevices");
            const notifList = document.getElementById("notifList");
            const notifBadge = document.getElementById("notifBadge");

            let notifications = [];
            let previousStatus = {};

            function fetchDeviceStats() {
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
                        document.getElementById("connectedDevices").textContent = "Failed to Load";
                        document.getElementById("onlineDevices").textContent = "Failed to Load";
                        document.getElementById("totalDevices").textContent = "Failed to Load";
                    });
            });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.1/socket.io.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
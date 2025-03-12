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
                <p>PC1 Forced Shutdown</p>
                <p>PC3 downloaded potetial risk file</p>
                <p>2 Critical Alerts</p>
                <p>2 Critical Alerts</p>
                <p>2 Critical Alerts</p>
                <p>2 Critical Alerts</p>
            </div>
        </div>
    </div>

    <!-- Monitoring Section -->
    <div class="monitoring-container max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10" id="monitoring-section">
        <h2 class="text-xl font-semibold mb-4">Monitoring</h2>
        <div class="pc-grid">
            @foreach(range(1, 10) as $i)
            <div class="pc-item" onclick="openModal('PC {{ $i }}', '{{ asset('/images/pc.png') }}')">
                <img src="{{ asset('images/pc.png') }}" alt="PC {{ $i }}">
                <div class="pc-info">
                    <p>PC Name: ${pc.name}</p>
                    <p>Status: ${pc.status}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Popup for Monitoring-->
    <div id="pcModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="pcTitle">PC Name: </h2>

            <img id="pcImage" src="" alt="PC Image" class="modal-img">

            <div class="modal-options">
                <button id="chatToggle"><i class="fas fa-comment"></i></button>
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
                    <input type="file" id="fileInput" class="custom-file-input"
                        accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt">
                    <input type="text" id="chatInput" placeholder="Type a message..." onkeypress="sendMessage(event)">
                    <button id="sendButton"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>

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
                <div class="pc-controls" style="none">
                    <button class="shutdown" title="Shutdown"><i class="fas fa-power-off"></i></button>
                    <button class="restart" title="Restart"><i class="fas fa-sync-alt"></i></button>
                    <button class="startup" title="Startup"><i class="fas fa-play"></i></button>
                    <button class="file-transfer" title="File Transfer"><i class="fas fa-file-upload"></i></button>
                    <button class="adv-opt" title="Advanced Options"><i class="fas fa-toolbox"></i></button>
                </div>
            </div>
            @endforeach
        </div>
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

    <button class="absolute top-5 left-5 bg-blue-500 text-white px-4 py-2 rounded" id="menuToggle">
        ☰
    </button>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
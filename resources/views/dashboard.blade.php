<title>NexusMattControl Admin</title>
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

    <button class="absolute top-5 left-5 bg-blue-500 text-white px-4 py-2 rounded z-50" id="menuToggle">
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
                    <input type="text" id="pc-port" class="form-control">
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
                <button id="chatToggle"><i class="fas fa-comment"></i></button>
            </div>

            <!-- Chat Box (Initially Hidden) -->
            <div id="chatModal" class="chat-modal" style="display: none;">
                <div class="chat-modal-content">
                    <span class="close-btn" onclick="closeChatModal()">&times;</span>
                    <h2>Chat</h2>
                    <div id="chatMessages" style="display: flex; flex-direction: column;"></div>
                <input type="text" id="chatInput" placeholder="Type a message..." onkeypress="sendMessage(event)">
                <button onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
            </div>
            </div>
        </div>
    </div>

   <!-- Control Section -->
<div class="control-container max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10" id="control-section">
    <h2 class="text-xl font-semibold mb-4">Controls</h2>
    <button id="selectAll" title="Select All"><i class="fa-solid fa-check"></i></button>
    <div class="mb-4 upload-button">
    <input type="file" id="globalFileInput" style="display: none;">
    <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded" title="Upload to Selected" onclick="document.getElementById('globalFileInput').click();">
       <i class="fas fa-file-upload"></i>
    </button>
    <button id="multiLockTimer" title="Set Timer for Selected" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
    <i class="fas fa-clock"></i>
</button>
 <button id="multiFileRequest" title="Multi File Request" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        <i class="fas fa-file-arrow-down"></i>
    </button>



</div>

    <div class="pc-grid" id="control-pcs">
        @foreach($subPcs as $subPc)
            <div class="pc-item">
                <input type="checkbox" class="pc-checkbox" data-ip="{{ $subPc->ip_address }}" style="position: absolute; top: 10px; left: 10px; z-index: 10;">

                <img src="{{ asset('images/pc.png') }}" alt="PC {{ $subPc->ip_address }}">
                <div class="pc-info">
                    <p>PC Name: <br>{{ $subPc->ip_address }}</p>
                    <p>Port: {{ $subPc->vnc_port }}</p>
                    <p class="pc-status" data-ip="{{ $subPc->ip_address }}">
                        Status: {{ $subPc->device_status }}
                    </p>
                    <div class="countdown-display mt-2 text-center">
                    <span id="countdown-{{ str_replace('.', '-', $subPc->ip_address) }}" style="font-weight: bold; color: #2f8f2f;"></span>
                    </div>
                </div>
                <div class="pc-controls" style="display: none;">
                    <button class="shutdown" data-ip="{{ $subPc->ip_address }}" title="Shutdown"><i
                            class="fas fa-power-off"></i></button>
                    <button class="restart" data-ip="{{ $subPc->ip_address }}" title="Restart"><i
                            class="fas fa-sync-alt"></i></button>
                    <button class="lock" data-ip="{{ $subPc->ip_address }}" title="Lock"><i
                            class="fa-solid fa-lock"></i></button>
                    <button class="lock-timer-btn" data-ip="{{ $subPc->ip_address }}" title="Start Timer">
                         <i class="fas fa-clock"></i>
                    </button>
                    <button 
                        class="send-request"
                        title="File Request"
                        data-ip="{{ $subPc->ip_address }}"
                        data-name="{{ $subPc->pc_name }}">  
                        <i class="fas fa-file-arrow-down"></i>
                    </button>

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
                            style="display:none; margin-top: 10px;">
                            <div class="progress-bar" id="progress-bar-{{ $subPc->ip_address }}" style="width: 100%;">
                            </div>
                        </div>
                    </form>

                    <button class="view-processes" data-ip="{{ $subPc->ip_address }}" title="View Background Processes">
                        <i class="fas fa-tasks"></i>
                    </button>
                    
                </div>
            </div>
        @endforeach
    </div>
</div>

  <!-- Lock Timer Modal -->
<div class="modal fade" id="lockTimerModal" tabindex="-1" aria-labelledby="lockTimerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3" id="timerLock">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="lockTimerModalLabel">Set Lock Timer</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="timerBody">
                <form id="lockTimerForm">
                    <input type="hidden" name="ip" id="lockTimerPcIp">

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <label for="lockTimerHours" class="form-label">Hours</label>
                            <input type="number" id="lockTimerHours" name="hours" class="form-control" min="0" max="23" placeholder="0" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="lockTimerMinutes" class="form-label">Minutes</label>
                            <input type="number" id="lockTimerMinutes" name="minutes" class="form-control" min="0" max="59" placeholder="0" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="lockTimerSeconds" class="form-label">Seconds</label>
                            <input type="number" id="lockTimerSeconds" name="seconds" class="form-control" min="0" max="59" placeholder="0" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Start Timer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Send Request Modal -->
<div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="requestModalLabel">Send Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-sm text-muted mb-2">
                    PC: <span id="modalPcName" class="fw-semibold"></span>
                </p>

                <div class="mb-3">
                    <label for="requestMessage" class="form-label">Message</label>
                    <textarea 
                        id="requestMessage" 
                        class="form-control"
                        rows="4"
                        placeholder="Type your message here..."></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="sendRequestBtn" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>


<meta name="csrf-token" content="{{ csrf_token() }}">

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
                <option value="lock">Lock</option>
                <option value="restart">Restart</option>
                <option value="file">File Transfer</option>
            </select>
        </div>

        <!-- Scrollable Logs Table -->
        <div class="bg-transparent dark:bg-gray-800 sm:rounded-lg pt-6 pb-6">
            <div class="logsTable  max-h-50 border rounded-lg">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.1/socket.io.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.socket.io/4.3.2/socket.io.min.js"></script>
</x-app-layout>
<nav x-data="{ open: false }" :class="open ? 'nav-open' : ''" class="">
        <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex nav-title">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('NexusControl') }}
                </x-nav-link>
            </div>
        </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div> @if(Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }} " 
                                        alt="Profile" class="profile-img rounded-circle me-2">
                                @else
                                    <img src="{{ asset('images/user.png') }}" 
                                        alt="Profile" class="profile-img rounded-circle me-2">
                                @endif
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                        <ul>
                    <li class="mb-2">
                        <a href="#dashboard" class="block px-4 py-2 rounded hover:bg-gray-700">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#monitoring-section" id="monitoring-link" class="block px-4 py-2 rounded hover:bg-gray-700">
                            <i class="fas fa-chart-line"></i> Monitoring
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#control-section" class="block px-4 py-2 rounded hover:bg-gray-700">
                            <i class="fas fa-cogs"></i> Controls
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#logs-section" class="block px-4 py-2 rounded hover:bg-gray-700">
                            <i class="fas fa-file-alt"></i> Logs
                        </a>
                    </li>
                </ul>
            </div>

                     <!-- 🔹 Navbar -->
<nav id="topNavbar" class="bg-gray-800 text-white z-50 h-16 flex items-center shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-between">

        <!-- 🔹 Left: Theme & Notification Buttons -->
        <div id="navtop" class="flex items-center space-x-3">
            <!-- Theme Switch -->
            <button id="switchBtn" class="btn btn-light">
                <i class="fa-solid fa-moon"></i>
            </button>

          <!-- Notification Bell -->
        <div class="dropdown">
            <button id="notifBtn" class="btn btn-light position-relative">
                <i class="fa-solid fa-bell"></i>
                <span id="notifBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">0</span>
            </button>

            <!-- Notification Dropdown -->
            <div id="notifDropdown" class="dropdown-menu dropdown-menu-end shadow">
                <h6 class="dropdown-header">Notifications</h6>
                <div id="notifList" class="list-group">
                    <p class="text-muted small text-center m-0">No new notifications</p>
                </div>
            </div>
        </div>



        <!-- 🔹 Right: User Dropdown -->
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-togg  le" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Log Out</button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</nav>

<!-- ✅ JavaScript to Fetch Notifications Dynamically -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    function fetchNotifications() {
        axios.get('/pc-status') // Adjust the API endpoint
            .then(response => {
                let notifications = [];
                let notifList = document.getElementById('notifList');
                let notifBadge = document.getElementById('notifBadge');

                response.data.forEach(pc => {
                    if (pc.device_status === 'online') {
                        notifications.push(`<a href="#" class="list-group-item list-group-item-action">
                            <strong>PC ${pc.ip_address}</strong> is now <span class="text-success">ONLINE</span>!</a>`);
                    }
                });

                if (notifications.length > 0) {
                    notifList.innerHTML = notifications.join('');
                    notifBadge.innerText = notifications.length;
                    notifBadge.classList.remove('d-none');
                } else {
                    notifList.innerHTML = `<p class="text-muted small text-center m-0">No new notifications</p>`;
                    notifBadge.classList.add('d-none');
                }
            })
            .catch(error => console.log('Error fetching notifications:', error));
    }

    setInterval(fetchNotifications, 10000); // Fetch notifications every 10 sec
});
</script>


            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
    <script src="js/navigation.js"></script>
    <!-- Add this before closing </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</nav>


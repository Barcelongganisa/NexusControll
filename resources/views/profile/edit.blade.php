<title>Profile</title>
<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    
    <x-slot name="header">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" id="nexus">
            {{ __('NexusControl') }}
        </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="container-fluid px-4"> <!-- Full-width container -->
            <div class="row g-4"> <!-- Bootstrap Grid with gap -->

                <!-- Profile Card (Full Width) -->
                <div class="col-12">
                    <div class="card shadow-sm h-100 min-vh-50 max-vw-100 d-flex flex-column profile-card">
                        <div class="overlay"></div> <!-- Dark overlay for readability -->
                        <div class="card-body text-center position-relative">
                            <!-- Display Profile Picture -->
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                                     class="rounded-circle mb-3 profile-img" width="120" alt="User Image">
                            @else
                                <img src="{{ asset('images/user.png') }}" 
                                     class="rounded-circle mb-3 profile-img" width="120" alt="User Image">
                            @endif
                            
                            <h5 class="card-title text-white">{{ Auth::user()->name }}</h5>
                            <p class="text-light">NexusControl Inc. Admin<br>Langaray Area, Barangay 14, Caloocan</p>
                            <div class="mt-auto">
                                <p class="text-light">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Info, Update Password, Delete Account (Side by Side) -->
                <div class="col-md-12">
                    <div class="card h-100 min-vh-50 max-vw-50 d-flex flex-column">
                        <div class="card-body d-flex flex-column" id="card-body">
                            <div class="flex-grow-1">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card h-100 min-vh-30 d-flex flex-column">
                        <div class="card-body d-flex flex-column" id="card-body">
                            <div class="flex-grow-1">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-12 mt-3">
                    <div class="card h-100">
                        <div class="card-body" id="card-body">
                            @include('profile.partials.create-user-form')
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card h-100">
                        <div class="card-body" id="card-body">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

            </div> 
        </div>
    </div>
    <script src="{{ asset('js/edit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>

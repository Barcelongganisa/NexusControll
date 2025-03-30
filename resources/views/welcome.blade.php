<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusControl</title>

    <!-- Bootstrap CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Optional: Bootstrap CDN (Remove if using Vite for Bootstrap) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/welcome.css') ?>">
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top glass-navbar">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand fw-bold text-white" href="#">NexusControl</a>

            <!-- Navbar Toggle -->
            <button class="navbar-toggler" type="button" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div id="navbarNav" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#contact">Contact</a></li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Log In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Main Content with Background -->
    <div class="background-container">
        <div class="overlay"></div> <!-- Optional for dark overlay -->
        <div class="welcome text-center">
            <h1 class="display-4 fw-bold">Welcome to NexusControl</h1>
            <p class="text-light mt-2">Efficient LAN-Based PC Monitoring and Control System</p>

            <!-- Updated Button Here -->
            <a href="#" class="btn homeBtn" data-bs-toggle="modal" data-bs-target="#loginModal">
                <span>Sign in now</span><span>Get Started</span>
            </a>
        </div>
    </div>



    <section id="features" class="section">
        <div class="container">
            <!-- Slider Start -->
            <ul class='slider'>
                <li class='item' style="background-image: url('/images/file-handling.jpeg')">
                    <div class='content'>
                        <h2 class='title'>File Handling</h2>
                        <p class='description'>Download & Upload File Control.</p>
                        <button class="read-more-btn" data-target="file-handling-content">Read More</button>
                    </div>
                </li>
                <li class='item' style="background-image: url('/images/computer1.jpg')">
                    <div class='content'>
                        <h2 class='title'>Features</h2>
                        <p class='description'>Powerful tools to monitor and manage LAN-connected PCs.</p>
                        <button class="read-more-btn" data-target="features-content">Read More</button>
                    </div>
                </li>
                <li class='item' style="background-image: url('/images/live.jpg')">
                    <div class='content'>
                        <h2 class='title'>Live Screen Monitoring</h2>
                        <p class='description'>View active screens in real time.</p>
                        <button class="read-more-btn" data-target="live-monitoring-content">Read More</button>
                    </div>
                </li>
                <li class='item' style="background-image: url('/images/performance.jpg')">
                    <div class='content'>
                        <h2 class='title'>Performance Monitoring</h2>
                        <p class='description'>Monitor real-time system health and resource usage.</p>
                        <button class="read-more-btn" data-target="performance-content">Read More</button>
                    </div>
                </li>
                <li class='item' style="background-image: url('/images/turnoff.jpg')">
                    <div class='content'>
                        <h2 class='title'>Shutdown/<br>Startup</h2>
                        <p class='description'>Manage power across multiple PCs easily.</p>
                        <button class="read-more-btn" data-target="shutdown-content">Read More</button>
                    </div>
                </li>
                <li class='item' style="background-image: url('/images/lock (2).jpg')">
                    <div class='content'>
                        <h2 class='title'>PC Locking</h2>
                        <p class='description'>Remotely lock unauthorized users out.</p>
                        <button class="read-more-btn" data-target="pc-locking-content">Read More</button>
                    </div>
                </li>
            </ul>

            <nav class='nav'>
                <ion-icon class='btn prev' name="arrow-back-outline"></ion-icon>
                <ion-icon class='btn next' name="arrow-forward-outline"></ion-icon>
            </nav>

            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        </div>
    </section>

    <!-- Hidden Content Sections -->
    <div id="features-content" class="hidden-content">
        <h3>Features</h3>
        <p>NexusControl is a LAN-based PC monitoring and control program designed to offer the administrator full
            control of multiple computers within a network. The software assists in the management of Internet cafés,
            school labs, offices, and training centers in securing help, which means better productivity and optimized
            operations from a single central PC.
            <br>
            <br>
            With NexusControl's advanced features, like real-time monitoring, remote control, and automated system
            management means that administrators can easily track activity, prevent misuse, and optimize performance
            without having to physically access eachas PC.
        </p>
        <button class="close-btn">Close</button>
    </div>
    <div id="live-monitoring-content" class="hidden-content">
    <h3>Live Screen Monitoring</h3>
    <p>NexusControl Live Screen Monitoring allows administrators to oversee multiple PCs from a central system without disrupting users. This enhances security, compliance, and productivity in workplaces, schools, or similar environments.  
        <br><br>
        With real-time monitoring, administrators can track activities, detect unauthorized actions, and take immediate action. Beyond screen viewing, they can remotely control PCs, log out users, and provide assistance when needed. This feature ensures a secure, well-managed, and efficient digital workspace.
    </p>
    <button class="close-btn">Close</button>
    </div>

    <div id="performance-content" class="hidden-content">
        <h3>Performance Monitoring</h3>
        <p>NexusControl’s Performance Monitoring allows administrators to track system health in real time, preventing potential issues before they arise.  
            <br><br>
            From a central PC, they can monitor CPU, RAM, disk activity, and network performance across connected devices. This helps identify bottlenecks, prevent slowdowns, and ensure smooth operations.  
            <br><br>
            With real-time insights, administrators can take preventive measures, keeping systems optimized and ensuring a stable computing environment.
        </p>
        <button class="close-btn">Close</button>
    </div>

    <div id="shutdown-content" class="hidden-content">
        <h3>Shutdown/Startup</h3>
        <p>Manually turning multiple PCs on/off is time-consuming, but NexusControl’s Automated Shutdown & Startup simplifies this by allowing administrators to send a single command to power on, restart, or shut down multiple PCs.  
            <br><br>
            This feature improves energy efficiency, security, and operations, making it ideal for offices, labs, and training centers. Administrators can schedule automatic PC startup/shutdowns, reducing energy waste and unauthorized access.  
            <br><br>
            With automated power management, NexusControl enhances efficiency, lowers energy costs, and streamlines operations.
        </p>
        <button class="close-btn">Close</button>
    </div>

    <div id="pc-locking-content" class="hidden-content">
        <h3>PC Locking</h3>
        <p>NexusControl’s PC Locking allows administrators to lock one or multiple PCs remotely, preventing unauthorized access and ensuring computers are used for their intended purposes in schools, offices, and training centers.  
            <br><br>
            With a click, administrators can freeze activity, display a custom lock screen, and unlock PCs when needed. This feature enhances security, prevents misuse, and ensures controlled access from a central system.
        </p>
        <button class="close-btn">Close</button>
    </div>

    <div id="file-handling-content" class="hidden-content">
        <h3>File Handling</h3>
        <p>NexusControl’s File Handling simplifies file management across multiple networked PCs. Administrators can seamlessly send, receive, organize, and manage files from a central workstation.  
            <br><br>
            Integrated with NexusControl’s monitoring system, this feature ensures secure, efficient file handling, minimizing security risks and improving productivity.
        </p>
        <button class="close-btn">Close</button>
    </div>

    <!-- About Section -->
    <section id="about" class="parallax-section">
        <div class="about-container text-white text-center">
            <h2 class="fw-bold">About Us</h2>
            <p>Learn more about our mission to provide efficient PC monitoring.</p>
        </div>
    </section>

    <!-- Second part (Profiles) -->
    <section id="team" class="team-section">
        <div class="team-container">
            <h2>Meet Our Team</h2>
            <div class="row">
                <div class="col-md-4 person">
                    <div class="container-inner">
                        <img src="/images/COLENDRES.png" class="circle" alt="Sherwin">
                        <img src="/images/background-circle.jpg" class="background-circle" alt="Background">
                        <div class="text-container">
                            <h3>Sherwin Colendres</h3>
                            <p>Main Programmer</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 person">
                    <div class="container-inner">
                        <img src="/images/BARCELON.png" class="circle" alt="Justine">
                        <img src="/images/background-circle.jpg" class="background-circle" alt="Background">
                        <div class="text-container">
                            <h3>Justine Barcelon</h3>
                            <p>Frontend Developer</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 person">
                    <div class="container-inner">
                        <img src="/images/VERGARA.png" class="circle" alt="Kurt">
                        <img src="/images/background-circle.jpg" class="background-circle" alt="Background">
                        <div class="text-container">
                            <h3>Kurt Vergara</h3>
                            <p>Backend Developer</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 person">
                    <div class="container-inner">
                        <img src="/images/SIWA.png" class="circle" alt="Jason">
                        <img src="/images/background-circle.jpg" class="background-circle" alt="Background">
                        <div class="text-container">
                            <h3>Jason Siwa</h3>
                            <p>Programmer</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 person">
                    <div class="container-inner">
                        <img src="/images/RAMIREZ.png" class="circle" alt="Clarence">
                        <img src="/images/background-circle.jpg" class="background-circle" alt="Background">
                        <div class="text-container">
                            <h3>Clarence Ramirez</h3>
                            <p>UX</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 person">
                    <div class="container-inner">
                        <img src="/images/PUNLA.png" class="circle" alt="Joyce">
                        <img src="/images/background-circle.jpg" class="background-circle" alt="Background">
                        <div class="text-container">
                            <h3>Joyce Ann Punla</h3>
                            <p>Documentation/UX & CX</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 person">
                    <div class="container-inner">
                        <img src="/images/GAB.png" class="circle" alt="Gab">
                        <img src="/images/background-circle.jpg" class="background-circle" alt="Background">
                        <div class="text-container">
                            <h3>Gabriel Domingo</h3>
                            <p>Member</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- Contact Section -->
    <section id="contact" class="section">
        <div class="container">
            <div class="contact-container">
                <div class="contact-info">
                    <h2>Contact Information</h2>
                    <p>Reach Out Anytime – We’re Ready to Assist!</p>

                    <div class="contact-item">
                        <img src="/images/phone.png" alt="Phone" width="18">
                        <span>09912200846</span>
                    </div>
                    <div class="contact-item">
                        <img src="/images/email.png" alt="Email" width="18">
                        <span>NexusControl@gmail.com</span>
                    </div>
                    <div class="contact-item">
                        <img src="/images/location.png" alt="Location" width="18">
                        <span>Langaray St., Barangay 14</span>
                    </div>
                </div>
                <div class="divider"></div> <!-- Thin Black Divider -->

                <div class="contact-form">
                    <div class="input-group">
                        <div>
                            <label>First Name</label>
                            <input type="text" placeholder="Enter your first name">
                        </div>
                        <div>
                            <label>Last Name</label>
                            <input type="text" placeholder="Enter your last name">
                        </div>
                    </div>

                    <div class="input-group">
                        <div>
                            <label>Email</label>
                            <input type="email" placeholder="Enter your email">
                        </div>
                        <div>
                            <label>Phone Number</label>
                            <input type="tel" placeholder="Enter your phone number">
                        </div>
                    </div>

                    <label>Message</label>
                    <textarea placeholder="Write your message.."></textarea>

                    <button class="send-btn">Send Message</button>
                </div>
            </div>
        </div>
    </div>
        </div> 
    </section>

    {{-- login modal --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Sign In to NexusControl</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Single Form: Fixes Issue -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" autocomplete="off" required>
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Remember Me Checkbox -->
                    {{-- <div class="mb-3 form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">Remember me</label>
                    </div> --}}

                    <!-- Google reCAPTCHA (Optional) -->
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    @error('g-recaptcha-response')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- forgot-password modal --}}
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center text-muted">
                    {{ __('Forgot your password? No problem. Just enter your email, and we will send you a reset link.') }}
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <x-input-label for="forgot_email" :value="__('Email')" />
                        <x-text-input id="forgot_email" class="block w-full form-control mt-1" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="d-flex justify-content-center">
                        <x-primary-button class="btn btn-primary">
                            {{ __('Email Password Reset Link') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <footer class="glass-container">
        <div class="morph-container d-flex justify-content-between align-items-center">
            <!-- Social Media Icons -->
            <div class="d-flex align-items-center">
                <a href="https://www.facebook.com/profile.php?id=61573894626769" target="_blank">
                    <img src="/images/facebook.png" alt="Facebook" class="social-icon">
                </a>
                <a href="https://www.linkedin.com" target="_blank">
                    <img src="/images/linkedin.png" alt="LinkedIn" class="social-icon">
                </a>
                <a href="https://x.com/nexuscontrol_ph?fbclid=IwY2xjawI97c9leHRuA2FlbQIxMAABHQy3RBTwW7B5G2tBfYs3INfQGqXepRmvpsmwvg1B_BErSpCxAglO84L9Jw_aem_Pj4jSESiKWYzAilKBfbmCA" target="_blank">
                    <img src="/images/twitter.png" alt="Twitter" class="social-icon">
                </a>
                <a href="https://www.instagram.com/nexuscontrol?igsh=NW5zMzVpaHltdDF1&fbclid=IwY2xjawI97fJleHRuA2FlbQIxMAABHYHUsow-XtOo9F6nH34OQkoe8cqWwD3YcfiXuG5LLtKzRVZhmjm5HjukOg_aem_aRqY81Z9uvT96sNbNFJnGg" target="_blank">
                    <img src="/images/instagram.png" alt="Instagram" class="social-icon">
                </a>
                <a href="https://github.com/Barcelongganisa/NexusControll" target="_blank">
                    <img src="/images/github.png" alt="GitHub" class="social-icon">
                </a>
            </div>

            <!-- Address -->
            <p class="footer-text">NEXUSCONTROL INC. HQ LANGARAY ST., BRGY 14, CALOOCAN CITY, PHILIPPINES.</p>
        </div>
    </footer>


    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/welcome.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log(typeof bootstrap !== "undefined" ? "✅ Bootstrap JS is loaded" :
            "❌ Bootstrap JS is NOT loaded");
    });
    </script>

    <!-- Bootstrap JavaScript (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
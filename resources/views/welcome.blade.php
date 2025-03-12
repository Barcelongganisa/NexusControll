<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusControl</title>

    <!-- Bootstrap CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Optional: Bootstrap CDN (Remove if using Vite for Bootstrap) -->
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
        <p>NexusControl Live Screen Monitoring allows the, administrator to take control and having visibility of
            multiple PC's from central system without disturbing the users. This promotes security, compliance, and
            productivity in the environment of the workplace, school, or similar networked environments.
            <br><br>
            With real-time monitoring, administrators can keep track of user activities, discover unauthorized acts, and
            take immediate actions whenever is needed be it an Internet café, school lab, or office network. This is a
            true ticket for keeping order and ensuring security.
            <br><br>
            Besides just screen viewing, administrators can also provide remote control of PCs, log out unauthorized
            users, or assist when required. Live Screen Monitoring contributes to a safer, better-managed, and more
            efficient digital workspace for every organization.
        </p>
        <button class="close-btn">Close</button>
    </div>

    <div id="performance-content" class="hidden-content">
        <h3>Performance Monitoring</h3>
        The monitoring of performance in a large enterprise comprises a host of various ways for collecting data about
        various states of computer systems. Performance Monitoring by NexusControl enables the administrator to monitor
        the systems for real-time health status and catch the potential problems before they actually become ones.
        <br><br>
        From one central PC, administrators can monitor CPU usage, RAM consumption, disk activity, and network
        performance across all the devices that are connected. This assists with spotting bottlenecks, preventing
        slowdowns, and providing for complete, efficient running throughout.
        <br><br>
        With real-time information, administrators can respond by taking preventive action and resolving issues before
        they become serious and ensure that all PCs are running optimally. It's useful for an office network, a school
        lab, or corporate IT. Performance Monitoring assures a stable, secure, and efficient computing environment. <br>
        <button class="close-btn">Close</button>
    </div>

    <div id="shutdown-content" class="hidden-content">
        <h3>Shutdown/Startup</h3>
        <p>Turning on or off multiple PCs will always add to the workload for any administrator managing a network. But
            with NexusControl's Automated Shutdown & Startup feature, it is possible to send a single command for
            powering on, restarting, or shutting down numerous PCs. Therefore, a huge amount of time and effort is freed
            up.
            <br><br>
            This software is applicable for an Internet café, a computer lab, an office, and a training center for the
            reasons of energy savings, security improvement, and operational streamlining. By using this solution, the
            administrator will create a schedule for booting PCs up before work and shutting them down after work so
            that energy will not be wasted nor anyone else will be allowed to log in to the working PCs.
            <br><br>
            Through automated power management, NexusControl enables reduction in manual work, lower energy costs, and
            efficiency in systems. No more turning PCs on or off one by one; we just need centralized control for a
            smarter, more economical network.
        </p>
        <button class="close-btn">Close</button>
    </div>

    <div id="pc-locking-content" class="hidden-content">
        <h3>PC Locking</h3>
        <p>With PC Locking by NexusControl, administrators are able to lock one or multiple computers from a distance,
            thus forbidding access to unauthorized users and sustains the workstation secured. Thus the computers are
            only used for their various intended purposes, and that is in schools, offices, or training centers.
            <br><br>
            Administrators can freeze activity just by a click; put a custom lock screen and, when needed, unlock any
            PCs. When a computer is not being attended to, or when certain limitations are required, it is locked right
            away for preventing any security threat or other misuse. With NexusControl’s PC Locking, access will become
            manageable, focus enhanced, and system protection made very simple—totally from a central control point.
        </p>
        <button class="close-btn">Close</button>
    </div>

    <div id="file-handling-content" class="hidden-content">
        <h3>File Handling</h3>
        <p>Managing files across a network of multiple computers can be challenging, more so when faced with massive
            quantities of data, security barriers, and the needs for seamless transfer of files. With NexusControl’s
            File Handling features, the administrator will be easy enough to send, receive, organize, and manage files
            across all connected sub-PCs from one central workstation.
            <br><br>
            NexusControl combines centralized file management capability with its broader PC monitoring and management
            system, ensuring that file handling is a piece of cake for any organization allowing them to focus on
            productivity without worrying about file access, security risks, or productivity inefficiencies.
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
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="mb-3 form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">Remember me</label>
                    </div>

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

<!-- Forgot Password Modal -->
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
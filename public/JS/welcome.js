document.addEventListener("DOMContentLoaded", function () {
    let menuToggle = document.querySelector(".navbar-toggler"); // Button
    let navbarCollapse = document.querySelector("#navbarNav"); // Collapsible menu

    if (menuToggle && navbarCollapse) {
        menuToggle.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent outside click event from triggering immediately
            
            if (navbarCollapse.classList.contains("show")) {
                closeMenu(); // If menu is open, close it
            } else {
                openMenu(); // Otherwise, open it
            }
        });

        function openMenu() {
            navbarCollapse.classList.add("show");
            document.addEventListener("click", closeMenuOutside);
        }

        function closeMenu() {
            navbarCollapse.classList.remove("show");
            document.removeEventListener("click", closeMenuOutside);
        }

        function closeMenuOutside(event) {
            if (!menuToggle.contains(event.target) && !navbarCollapse.contains(event.target)) {
                closeMenu();
            }
        }
    } else {
        console.error("Navbar toggler or navbarNav not found.");
    }
});

// FEATURES -- SLIDER
const slider = document.querySelector('.slider');

function activate(e) {
  const items = document.querySelectorAll('.item');

  if (e.target.matches('.next') || e.key === "ArrowRight") {
    slider.append(items[0]); // Move first item to the end
  }

  if (e.target.matches('.prev') || e.key === "ArrowLeft") {
    slider.prepend(items[items.length - 1]); // Move last item to the start
  }
}

// Click Event for Buttons
document.addEventListener('click', activate, false);

// Keyboard Arrow Key Event
document.addEventListener('keydown', (e) => {
  if (e.key === "ArrowRight" || e.key === "ArrowLeft") {
    activate(e); // Call the same function for consistency
  }
});

document.addEventListener("scroll", function () {
    const teamSection = document.getElementById("team");
    const teamRect = teamSection.getBoundingClientRect();

    if (teamRect.top < window.innerHeight - 100) {
        teamSection.classList.add("show");
    }
});

// PARA TO SA FEATURES YUNG MAY READMMORE
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".read-more-btn");
    const closeButtons = document.querySelectorAll(".close-btn");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            const targetId = this.getAttribute("data-target");
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                targetElement.style.display = "block";
            } else {
                console.error(`Error: Element with ID '${targetId}' not found.`);
            }
        });
    });

    closeButtons.forEach(button => {
        button.addEventListener("click", function () {
            this.parentElement.style.display = "none";
        });
    });
});

// Get all read more buttons and close buttons
const readMoreBtns = document.querySelectorAll('.read-more-btn');
const closeBtns = document.querySelectorAll('.close-btn');
const hiddenContents = document.querySelectorAll('.hidden-content');
const body = document.querySelector('.body'); // The main content area to blur

// Show the corresponding modal and blur background
readMoreBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-target');
        const targetContent = document.getElementById(targetId);
        
        if (targetContent) {
            targetContent.classList.add('show');
            body.classList.add('blur');
        }
    });
});

// Close modal and remove blur
closeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        hiddenContents.forEach(content => content.classList.remove('show'));
        body.classList.remove('blur');
    });
});

    document.addEventListener("DOMContentLoaded", function () {
        // Remove modal backdrop when any modal is closed
        document.addEventListener("hidden.bs.modal", function () {
            if (document.querySelector(".modal-backdrop")) {
                document.querySelector(".modal-backdrop").remove();
            }
            document.body.classList.remove("modal-open"); // Remove the modal-open class
            document.body.style.overflow = "auto"; // Allow scrolling again
        });
    });
document.addEventListener("DOMContentLoaded", function () {
    const forgotPasswordLink = document.querySelector(".open-forgot-password");
    if (!forgotPasswordLink) return; // Exit if the element isn't found

    forgotPasswordLink.addEventListener("click", function (event) {
        event.preventDefault();

        const loginModal = document.getElementById("loginModal");
        const forgotPasswordModal = document.getElementById("forgotPasswordModal");

        if (!loginModal || !forgotPasswordModal) return; // Exit if modals aren't found

        // Make login modal invisible but still present
        loginModal.style.opacity = "0";
        loginModal.setAttribute("inert", ""); 

        // Show Forgot Password Modal
        new bootstrap.Modal(forgotPasswordModal).show();

        // Restore login modal when Forgot Password closes
        forgotPasswordModal.addEventListener("hidden.bs.modal", function () {
            loginModal.style.opacity = "1";
            loginModal.removeAttribute("inert");
        }, { once: true });
    });
});
$('#loginModal, #forgotPasswordModal').on('hidden.bs.modal', function () {
    $(this).find('input, textarea, select, button').blur(); // Remove focus
    $(this).removeAttr('aria-hidden'); // Ensure it is not hidden improperly
});

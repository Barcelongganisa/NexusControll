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

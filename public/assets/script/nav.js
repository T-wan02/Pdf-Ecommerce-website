const navBar = document.getElementById('navbar');

window.addEventListener("DOMContentLoaded", () => {
     window.addEventListener("scroll", () => {
          const scrollPosition = window.scrollY; // Use window.scrollY to get the scroll position
          if (scrollPosition > 50) {
               if(navBar){
                    navBar.style.backgroundColor = "white"; // Change background color of nav bar
               }
          }
     });
});

// Responsive nav bar
const toggleNav = document.getElementById('toggleNav');
const responsiveNavItemContainer = document.getElementById('responsiveNavItemContainer');  // Responsive nav bar

let toggleStatus = false; // Toggle nav status

toggleNav.addEventListener('click', (e) => {
     if(toggleStatus){
          // Disable scrolling
          document.body.style.overflow = 'hidden';

          toggleStatus = false; // Set staus to opposite

          toggleNav.innerHTML = `<i class="fa-solid fa-xmark"></i>`; // Set icon to X close

          responsiveNavItemContainer.classList.toggle('active'); // Add active class to Responsive nav container
     }else{
          // Re-enable scrolling
          document.body.style.overflow = 'visible';

          toggleStatus = true; // Set status to opposite

          toggleNav.innerHTML = `<i class="fa-solid fa-bars"></i>`; // Set icon to bars burgur menu

          responsiveNavItemContainer.classList.remove('active'); // Remove active class from Responsive nav container
     }
});

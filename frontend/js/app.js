//js/app.js

/* Main App Initialization File 
   Loads layout components and initializes page modules dynamically
 */

document.addEventListener("DOMContentLoaded", async () => {
    try {
        const rooms = await getAllRooms();
        const availableRooms = await getAvailableRooms();
        const bookings = await getAllBooking();
        const recentBookings = await getRecentBooking();
        const guests = await getAllGuests();

        dashboardModule.loadStatisticsCards({ rooms, availableRooms, bookings, recentBookings, guests });
        dashboardModule.loadRecentBookingsTable(recentBookings);
    } catch (error) {
        console.error("Error initializing dashboard:", error);
    }
});

/* Load Sidebar, Navbar, and Footer Components into placeholders */
function loadLayoutComponents() {
    // Load Sidebar 
    fetch("/components/sidebar.html")
        .then(response => response.text())
        .then(html => {
            document.getElementById("sidebar-placeholder").innerHTML = html;
        })
        .catch(error => console.error("Error loading sidebar:", error));
    // Load Navbar
    fetch("/components/navbar.html")
        .then(response => response.text())
        .then(html => {
            document.getElementById("navbar-placeholder").innerHTML = html;
        })
        .catch(error => console.error("Error loading navbar:", error));
    // Load Footer
    fetch("/components/footer.html")
        .then(response => response.text())
        .then(html => {
            document.getElementById("footer-placeholder").innerHTML = html;
        })
        .catch(error => console.error("Error loading footer:", error));
}
/* Initialize correct page module based on the file name
   - index.html -> dashboardModule
   - rooms.html -> roomsModule
   - guests.html -> guestsModule
   - bookings.html -> bookingsModule
 */

function initializePageModule() {
    const page = window.location.pathname.split("/").pop();

    switch (page) {
        case "index.html":
            dashboardModule.init();
            break;
        case "rooms.html":
            roomsModule.init();
            break;
        case "guests.html":
            guestsModule.init();
            break;
        case "bookings.html":
            bookingsModule.init();
            break;
        default:
            console.warn("No module found for this page:", page);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    loadLayoutComponents();
    initializePageModule();
});

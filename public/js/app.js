const sidebarToggle = document.getElementById('sidebar-toggle');
const sidebar = document.getElementById('sidebar');

sidebarToggle.addEventListener('click', function() {
  sidebar.classList.toggle('open'); // Toggle the 'open' class on the sidebar
});
if (!isSidebarToggle && !isSidebar && sidebar.classList.contains('open')) {
    sidebar.classList.remove('open');
  }
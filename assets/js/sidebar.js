document.addEventListener('DOMContentLoaded', function() {
    // Wait for Bootstrap to initialize
    setTimeout(() => {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        
        if (sidebar && sidebarToggle) {
            // Load saved state from localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
            }
            
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                sidebar.classList.toggle('collapsed');
                
                // Save state to localStorage
                const collapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', collapsed);
                
                // Add a small animation feedback
                this.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
            
            // Add hover tooltips for collapsed state
            const sidebarLinks = sidebar.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                const title = link.getAttribute('title');
                if (title) {
                    link.addEventListener('mouseenter', function() {
                        if (sidebar.classList.contains('collapsed')) {
                            showTooltip(this, title);
                        }
                    });
                    
                    link.addEventListener('mouseleave', function() {
                        hideTooltip();
                    });
                }
            });
        }
    }, 100);
});

// Tooltip functions for collapsed sidebar
let tooltipElement = null;

function showTooltip(element, text) {
    hideTooltip(); // Remove any existing tooltip
    
    tooltipElement = document.createElement('div');
    tooltipElement.className = 'sidebar-tooltip';
    tooltipElement.textContent = text;
    document.body.appendChild(tooltipElement);
    
    const rect = element.getBoundingClientRect();
    tooltipElement.style.left = (rect.right + 10) + 'px';
    tooltipElement.style.top = (rect.top + rect.height / 2 - tooltipElement.offsetHeight / 2) + 'px';
    
    // Add show class for animation
    setTimeout(() => {
        if (tooltipElement) {
            tooltipElement.classList.add('show');
        }
    }, 10);
}

function hideTooltip() {
    if (tooltipElement) {
        tooltipElement.remove();
        tooltipElement = null;
    }
}
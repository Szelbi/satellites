document.addEventListener('DOMContentLoaded', function() {
    const btnReloader = document.getElementById('btn-reloader');
    
    if (btnReloader) {
        btnReloader.addEventListener('click', function() {
            // Get the weather update URL from data attribute or global variable
            const updateUrl = window.weatherUpdateUrl;
            
            fetch(updateUrl)
                .then(response => response.json())
                .then(data => {
                    // Update all data fields
                    document.querySelectorAll('tbody td[data-key]').forEach(cell => {
                        cell.textContent = data[cell.getAttribute('data-key')];
                    });
                    
                    // Update timestamps
                    const lastUpdatedEl = document.getElementById('last-updated');
                    const requestTimeEl = document.getElementById('request-time');
                    
                    if (lastUpdatedEl) lastUpdatedEl.textContent = data.lastUpdated;
                    if (requestTimeEl) requestTimeEl.textContent = data.requestTime;
                })
                .catch(error => console.error('Error fetching weather data:', error));
        });
    }
});
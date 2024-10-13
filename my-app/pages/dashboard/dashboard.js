document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent page reload
        const page = this.getAttribute('data-page');

        // Load content dynamically using fetch
        fetch(`${baseURL}pages/sidebarOptions/${page}.php`) // Use baseURL defined above
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                document.querySelector('.dashboard-content').innerHTML = data;
            })
            .catch(error => console.log('Error loading content:', error));
    });
});

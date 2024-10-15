document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent page reload
        const page = this.getAttribute('data-page');
        console.log(`Fetching content from: ${baseURL}pages/sidebarOptions/${page}.php`);

        // Load content dynamically using fetch
        fetch(`${baseURL}pages/sidebarOptions/${page}.php`)
            .then(response => {
                console.log('Response status:', response.status); // Log the response status
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                console.log('Fetched content:', data); // Log fetched content
                document.querySelector('.dashboard-content').innerHTML = data;
            })
            .catch(error => console.log('Error loading content:', error));
    });
});

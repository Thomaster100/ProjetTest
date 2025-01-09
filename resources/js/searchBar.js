document.addEventListener('DOMContentLoaded', function () {
    
    const searchBar = document.getElementById('search-bar');
    const resultsContainer = document.getElementById('search-results');

    searchBar.addEventListener('input', function () {
       
        const query = searchBar.value;

        document.getElementById('loading-spinner').style.display = 'block';
    
        fetch(`/search?query=${query}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            resultsContainer.innerHTML = data.html;
        })
        .finally(() => {
            document.getElementById('loading-spinner').style.display = 'none';
        })
        .catch(error => console.error('Erreur lors de la recherche :', error));
    });

});
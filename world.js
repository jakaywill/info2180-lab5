document.addEventListener("DOMContentLoaded", () => {
    const phpfile = 'http://localhost/info2180-lab5/world.php';
    const srchBttn = document.getElementById('lookup');
    const ctysrchBttn = document.getElementById('citysearch');
    const srchBar = document.getElementById('country');
    const result = document.getElementById('result');

    const getRequest = (query, option) => {
        fetch(`${phpfile}?country=${encodeURIComponent(query)}&lookup=${encodeURIComponent(option)}`)
            .then(response => response.text())
            .then(data => {
                result.innerHTML = data;
            })
            .catch(error => {
                alert(`Error: ${error}`);
            });
    };

    ctysrchBttn.addEventListener('click', () => {
        const query = srchBar.value.trim();
        getRequest(query, 'cities');
    });

    srchBttn.addEventListener('click', () => {
        const query = srchBar.value.trim();
        getRequest(query, '');
    });
});

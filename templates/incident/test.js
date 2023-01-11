
document.addEventListener('DOMContentLoaded', function() {
    const dateSelect = document.getElementById('incident_date');
    dateSelect.addEventListener('change', function(e) {
        const formI = dateSelect.closest('form');
        fetch(formI.action, {
            method: formI.method,
            body: new FormData(formI)
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newCityFormFieldEl = doc.getElementById('incident_idBail');
            newCityFormFieldEl.addEventListener('change', function(e) {
                e.target.classList.remove('is-invalid');
            });
            document.getElementById('incident_idBail').replaceWith(newCityFormFieldEl);
        })
        .catch(function (err) {
            console.warn('Something went wrong.', err);
        });
    });
});

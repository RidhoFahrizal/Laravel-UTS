import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

/*
document.addEventListener('DOMContentLoaded', () => {
    fetch('http://localhost:8000/api/products')
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => console.error('Error:', error));
});
*/

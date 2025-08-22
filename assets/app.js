import './bootstrap.js';
import './../public/assets/js/bootstrap.bundle.min.js';
import './../public/assets/js/validate.js';
import './../public/assets/js/aos.js';
import './../public/assets/js/glightbox.min.js';
import './../public/assets/js/imagesloaded.pkgd.min';
import './../public/assets/js/isotope.pkgd.min';
import './../public/assets/js/noframework.waypoints.js';
import './../public/assets/js/swiper-bundle.min.js';
import './../public/assets/js/main.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import './../public/assets/css/bootstrap.min.css';
import './../public/assets/css/bootstrap-icons/bootstrap-icons.css';
import './../public/assets/css/aos.css';
import './../public/assets/css/glightbox.min.css';
import './../public/assets/css/swiper-bundle.min.css';
import './../public/assets/css/main.css';


document.addEventListener('DOMContentLoaded', function () {
    const firstFac = document.querySelector('#candidate_form_facOne');
    const firstChoice = document.querySelector('#candidate_form_fistChoice');
    const secondFac = document.querySelector('#candidate_form_factTwo');
    const secondChoice = document.querySelector('#candidate_form_secondChoice');

    firstChoice.innerHTML = '';
    secondChoice.innerHTML = '';

    const holderOne = document.createElement('option');
    holderOne.value = '';
    holderOne.textContent = 'Choisissez une filière';
    holderOne.disabled = true;
    holderOne.selected = true;
    firstChoice.appendChild(holderOne);

    const holderTwo = document.createElement('option');
    holderTwo.value = '';
    holderTwo.textContent = 'Choisissez une filière';
    holderTwo.disabled = true;
    holderTwo.selected = true;
    secondChoice.appendChild(holderTwo);

    firstFac.addEventListener('change', function () {
        const facId = firstFac.value;
        fetch('/sectors/' + facId)
            .then(response => response.json())
            .then(data => {
                firstChoice.innerHTML = '';
                data.data.forEach(filiere => {
                    const option = document.createElement('option');
                    option.value = filiere.id;
                    option.textContent = filiere.name;
                    firstChoice.appendChild(option);
                });
            });
    });
    secondFac.addEventListener('change', function () {
        const facId = secondFac.value;
        fetch('/sectors/' + facId)
            .then(response => response.json())
            .then(data => {
                secondChoice.innerHTML = '';
                data.data.forEach(filiere => {
                    const option = document.createElement('option');
                    option.value = filiere.id;
                    option.textContent = filiere.name;
                    secondChoice.appendChild(option);
                });
            });
    });
});


/**
 * assets/js/script.js
 * -------------------------------------------------------
 * A few small, beginner-friendly behaviours used across
 * the site. Nothing here is required for the site to work
 * (everything important happens server-side in PHP) - this
 * file just makes the experience feel a bit nicer.
 * -------------------------------------------------------
 */

document.addEventListener('DOMContentLoaded', function () {

    /* ---- 1. Password show/hide toggle on login & signup ---- */
    document.querySelectorAll('.password-toggle').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            var input = document.getElementById(toggle.dataset.target);
            if (!input) return;

            var showing = input.type === 'text';
            input.type = showing ? 'password' : 'text';
            toggle.textContent = showing ? 'Show' : 'Hide';
        });
    });

    /* ---- 2. Stagger the little pop-in animation on cards ---- */
    document.querySelectorAll('.stagger > *').forEach(function (el, index) {
        el.style.animationDelay = (index * 0.07) + 's';
        el.classList.add('animate-pop');
    });

    /* ---- 3. Friendlier Bootstrap form validation feedback ---- */
    document.querySelectorAll('form[novalidate]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    /* ---- 4. Auto-dismiss success/error banners after a while ---- */
    document.querySelectorAll('.flash-wrap .alert').forEach(function (alertEl) {
        setTimeout(function () {
            var alert = bootstrap.Alert.getOrCreateInstance(alertEl);
            alert.close();
        }, 6000);
    });

    /* ---- 5. Live character counter for the blog/letter textareas ---- */
    document.querySelectorAll('textarea[data-maxlength]').forEach(function (textarea) {
        var max = parseInt(textarea.dataset.maxlength, 10);
        var counter = document.createElement('div');
        counter.className = 'form-text text-end';
        textarea.insertAdjacentElement('afterend', counter);

        function updateCount() {
            counter.textContent = textarea.value.length + ' / ' + max;
        }
        textarea.addEventListener('input', updateCount);
        updateCount();
    });

    /* ---- 6. Baking page: let Enter/Space "click" a recipe card too ---- */
    document.querySelectorAll('.bake-card[data-recipe-index]').forEach(function (card) {
        card.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                card.click();
            }
        });
    });
});

/**
 * Shows the full recipe (ingredients + steps) for the card that was
 * clicked, inside the #recipe-detail panel below the grid.
 * Called directly from the onclick="" attribute on each recipe card.
 */
function showRecipe(index) {
    var recipe = window.cozyRecipes && window.cozyRecipes[index];
    var panel = document.getElementById('recipe-detail');
    if (!recipe || !panel) return;

    var ingredientItems = recipe.ingredients.map(function (item) {
        return '<li>' + item + '</li>';
    }).join('');

    var stepItems = recipe.steps.map(function (step) {
        return '<li>' + step + '</li>';
    }).join('');

    panel.innerHTML =
        '<div class="recipe-detail-card">' +
            '<button type="button" class="recipe-close" onclick="closeRecipe()" aria-label="Close recipe">✕</button>' +
            '<h2>' + recipe.emoji + ' ' + recipe.title + '</h2>' +
            '<p class="recipe-meta">⏱ ' + recipe.time + ' &nbsp;·&nbsp; 🍽 ' + recipe.servings + '</p>' +
            '<div class="recipe-columns">' +
                '<div>' +
                    '<h3>Ingredients</h3>' +
                    '<ul>' + ingredientItems + '</ul>' +
                '</div>' +
                '<div>' +
                    '<h3>Steps</h3>' +
                    '<ol>' + stepItems + '</ol>' +
                '</div>' +
            '</div>' +
        '</div>';

    panel.classList.add('show');

    // Highlight the selected card so it's clear which recipe is open.
    document.querySelectorAll('.bake-card').forEach(function (card, i) {
        card.classList.toggle('selected', i === index);
    });

    panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

/** Closes the open recipe panel and clears the card highlight. */
function closeRecipe() {
    var panel = document.getElementById('recipe-detail');
    if (!panel) return;

    panel.classList.remove('show');
    panel.innerHTML = '<p class="recipe-placeholder text-center text-white mb-0">' +
        'Select a recipe above to see the full ingredients and steps here. 🍴</p>';

    document.querySelectorAll('.bake-card').forEach(function (card) {
        card.classList.remove('selected');
    });
}

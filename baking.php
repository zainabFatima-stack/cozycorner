<?php
require_once 'includes/functions.php';
$pageTitle = 'Baking';
require 'includes/header.php';

// Each recipe has everything needed for both the card AND the
// full recipe view that appears when you click a card.
$recipes = [
    [
        'title' => 'Chocolate Cake', 'emoji' => '🍫',
        'desc'  => 'Rich and moist chocolate cake perfect for any occasion.',
        'time' => '45 mins', 'servings' => 'Serves 8',
        'ingredients' => [
            '2 cups all-purpose flour', '1 cup sugar', '1/2 cup cocoa powder',
            '2 eggs', '1 cup milk', '1/2 cup vegetable oil',
            '1 tsp baking powder', '1 tsp vanilla extract',
        ],
        'steps' => [
            'Preheat your oven to 180°C (350°F) and grease a cake tin.',
            'Mix the flour, cocoa powder, and baking powder in a bowl.',
            'In another bowl, whisk the eggs, milk, oil, and vanilla together.',
            'Combine the wet and dry ingredients until smooth.',
            'Pour into the tin and bake for 30-35 minutes.',
            'Let it cool completely before frosting and slicing.',
        ],
    ],
    [
        'title' => 'Vanilla Cupcakes', 'emoji' => '🧁',
        'desc'  => 'Soft and fluffy cupcakes with creamy frosting.',
        'time' => '25 mins', 'servings' => 'Makes 12',
        'ingredients' => [
            '1 1/2 cups flour', '1 cup sugar', '1/2 cup butter, softened',
            '2 eggs', '1/2 cup milk', '1 1/2 tsp baking powder', '1 tsp vanilla extract',
        ],
        'steps' => [
            'Preheat oven to 180°C (350°F) and line a muffin tray with cupcake liners.',
            'Cream the butter and sugar together until light and fluffy.',
            'Beat in the eggs one at a time, then add the vanilla.',
            'Fold in the flour and baking powder, alternating with the milk.',
            'Divide batter evenly into liners and bake for 18-20 minutes.',
            'Cool fully, then top with your favourite frosting.',
        ],
    ],
    [
        'title' => 'Brownies', 'emoji' => '🍪',
        'desc'  => 'Fudgy chocolate brownies with a crispy top.',
        'time' => '35 mins', 'servings' => 'Serves 9',
        'ingredients' => [
            '1 cup butter, melted', '2 cups sugar', '4 eggs',
            '1 cup cocoa powder', '1 cup flour', '1/2 tsp salt', '1 tsp vanilla extract',
        ],
        'steps' => [
            'Preheat oven to 175°C (350°F) and line a square baking pan.',
            'Whisk the melted butter and sugar together until glossy.',
            'Beat in the eggs and vanilla extract.',
            'Fold in the cocoa powder, flour, and salt - don\'t overmix.',
            'Pour into the pan and bake for 25-28 minutes.',
            'Cool completely before cutting into squares.',
        ],
    ],
    [
        'title' => 'Strawberry Tart', 'emoji' => '🍓',
        'desc'  => 'Fresh strawberries with a buttery crust.',
        'time' => '50 mins', 'servings' => 'Serves 6',
        'ingredients' => [
            '1 pre-baked tart shell', '2 cups fresh strawberries, sliced',
            '1 cup cream cheese, softened', '1/4 cup sugar',
            '1 tsp vanilla extract', '2 tbsp apricot jam (for glaze)',
        ],
        'steps' => [
            'Beat the cream cheese, sugar, and vanilla together until smooth.',
            'Spread the mixture evenly into the cooled tart shell.',
            'Arrange the sliced strawberries on top in a circular pattern.',
            'Warm the apricot jam slightly and brush it over the strawberries for shine.',
            'Chill in the fridge for at least 30 minutes before serving.',
        ],
    ],
    [
        'title' => 'Cookies', 'emoji' => '🍪',
        'desc'  => 'Classic chocolate chip cookies everyone loves.',
        'time' => '20 mins', 'servings' => 'Makes 18',
        'ingredients' => [
            '1 cup butter, softened', '3/4 cup sugar', '3/4 cup brown sugar',
            '2 eggs', '2 1/4 cups flour', '1 tsp baking soda',
            '1 1/2 cups chocolate chips',
        ],
        'steps' => [
            'Preheat oven to 190°C (375°F) and line a baking tray.',
            'Cream the butter, sugar, and brown sugar together.',
            'Beat in the eggs, then mix in the flour and baking soda.',
            'Fold in the chocolate chips.',
            'Scoop spoonfuls onto the tray, spaced apart.',
            'Bake for 9-11 minutes until the edges turn golden.',
        ],
    ],
    [
        'title' => 'Cheesecake', 'emoji' => '🍰',
        'desc'  => 'Creamy cheesecake with a smooth, dreamy texture.',
        'time' => '70 mins + chilling', 'servings' => 'Serves 10',
        'ingredients' => [
            '1 1/2 cups crushed digestive biscuits', '1/3 cup melted butter',
            '3 cups cream cheese, softened', '1 cup sugar',
            '3 eggs', '1 tsp vanilla extract', '1/2 cup sour cream',
        ],
        'steps' => [
            'Mix the crushed biscuits with melted butter and press into a tin to form the base.',
            'Beat the cream cheese and sugar together until smooth.',
            'Add the eggs one at a time, then the vanilla and sour cream.',
            'Pour the filling over the biscuit base.',
            'Bake at 160°C (320°F) for about 50 minutes, until just set in the middle.',
            'Cool, then chill in the fridge for at least 4 hours before serving.',
        ],
    ],
];

// Send the same recipe data to JavaScript so clicking a card can
// show the full recipe instantly, with no page reload needed.
?>

<div class="hero-page page-baking-hero" style="padding-top:120px; padding-bottom:60px;">
    <div class="container">
        <h1 class="text-center text-white mb-3" style="text-shadow:0 2px 12px rgba(0,0,0,.35);">
            Delicious Baking Recipes
        </h1>
        <p class="text-center text-white mb-5" style="text-shadow:0 1px 8px rgba(0,0,0,.3);">
            👆 Click any recipe card to see the full ingredients &amp; steps
        </p>

        <div class="row g-4 stagger">
            <?php foreach ($recipes as $index => $r): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="bake-card text-center h-100"
                         role="button"
                         tabindex="0"
                         data-recipe-index="<?= $index ?>"
                         onclick="showRecipe(<?= $index ?>)">
                        <div style="font-size:2.2rem;"><?= $r['emoji'] ?></div>
                        <h3><?= e($r['title']) ?></h3>
                        <p class="mb-1"><?= e($r['desc']) ?></p>
                        <span class="bake-card-hint">View full recipe →</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- The full recipe appears here once a card is clicked -->
        <div id="recipe-detail" class="recipe-detail mt-5">
            <p class="recipe-placeholder text-center text-white mb-0">
                Select a recipe above to see the full ingredients and steps here. 🍴
            </p>
        </div>
    </div>
</div>

<script>
    // All the recipe data, ready for the showRecipe() function in script.js to use.
    window.cozyRecipes = <?= json_encode($recipes, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
</script>

<?php require 'includes/footer.php'; ?>

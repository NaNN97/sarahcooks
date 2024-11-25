<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SarahCooks</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include_once('header.php'); ?>

    <!-- Hero Section -->
    <section class="hero">
        <h2>Welcome to SarahCooks</h2>
        <p>Discover recipes, cooking tips, and much more!</p>
        <button onclick="location.href='#recipes'">Explore Recipes</button>
    </section>

    <!-- Recipes Section -->
    <section class="recipes" id="recipes">
        <h2>Our Recipes</h2>
        <div class="recipe-grid">
            <!-- Example Recipe Card -->
            <div class="recipe-card">
                <div class="image-placeholder">
                    <p>Image Placeholder</p>
                </div>
                <h3>Recipe Title</h3>
                <p>Short description of the recipe...</p>
                <button>View Recipe</button>
            </div>

            <?php
            // Database connection
            $pdo = new PDO("mysql:host=localhost;dbname=sarahcooks", "root", "");

            // Fetch all recipes
            $stmt = $pdo->query("SELECT * FROM recipes");
            $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $imageStmt = $pdo->query("SELECT * FROM recipe_images");
            $image = $imageStmt->fetch(PDO::FETCH_ASSOC);

            if ($recipes) {
                foreach ($recipes as $recipe) {
                    echo '<div class="recipe-card">';
                    if ($image) {
                        echo '<div class="image-placeholder">';
                        echo '<img src=' . htmlspecialchars($image['image_path']) . ' alt="Recipe Image">';
                        echo '</div>';
                    } else {
                      echo "<p>Image not found!</p>";
                    }
                    echo '<h3>' . htmlspecialchars($recipe['title']) . '</h3>';
                    echo '<p>' . htmlspecialchars($recipe['subtitle']) . '</p>';
                    echo '<button onclick="location.href=\'recipe.php?id=' . $recipe['id'] . '\'">View Recipe</button>';
                    echo '</div>';
                }
            } else {
                echo "<p>No recipes found!</p>";
            }
            ?>

        </div>
    </section>

    <?php include_once('footer.php')?>
</body>
</html>

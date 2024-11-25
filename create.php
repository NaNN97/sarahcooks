<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "sarahcooks");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $cooking_time = $_POST['cooking_time'];
    $serving = $_POST['serving'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $calories = $_POST['calories'];
    $instructions = $_POST['instructions'];

    // Insert recipe into recipes table
    $sql = "INSERT INTO recipes (title, subtitle, cooking_time, serving, description, ingredients, calories, instructions) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssis", $title, $subtitle, $cooking_time, $serving, $description, $ingredients, $calories, $instructions);

    if ($stmt->execute()) {
        $recipe_id = $stmt->insert_id;

        // Handle image upload
        if (!empty($_FILES['recipe_image']['name'])) {
            $image_name = basename($_FILES['recipe_image']['name']);
            $target_file = "assets/img/" . $image_name;

            // Check and move the uploaded file
            if (move_uploaded_file($_FILES['recipe_image']['tmp_name'], $target_file)) {
                $image_sql = "INSERT INTO recipe_images (recipe_id, image_path) VALUES (?, ?)";
                $image_stmt = $conn->prepare($image_sql);
                $image_stmt->bind_param("is", $recipe_id, $target_file);
                $image_stmt->execute();
            } else {
                echo "<p>Error uploading image.</p>";
            }
        }

        echo "<p>Recipe added successfully!</p>";
    } else {
        echo "<p>Error adding recipe: " . $conn->error . "</p>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <link rel="stylesheet" href="assets/css/create.css">
</head>
<body>
  <?php include_once('header.php'); ?>
    <div class="form-container">
        <h1>Add New Recipe</h1>
        <form action="create.php" method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="subtitle">Subtitle:</label>
            <input type="text" name="subtitle" id="subtitle" required>

            <label for="cooking_time">Cooking Time (minutes):</label>
            <input type="number" name="cooking_time" id="cooking_time" required>

            <label for="serving">Servings:</label>
            <input type="number" name="serving" id="serving" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>

            <label for="ingredients">Ingredients:</label>
            <textarea name="ingredients" id="ingredients" required></textarea>

            <label for="calories">Calories:</label>
            <input type="number" name="calories" id="calories">

            <label for="instructions">Instructions:</label>
            <textarea name="instructions" id="instructions" required></textarea>

            <label for="recipe_image">Recipe Image:</label>
            <input type="file" name="recipe_image" id="recipe_image" accept="image/*">

            <button type="submit">Add Recipe</button>
        </form>
    </div>

    <?php include_once('footer.php')?>
</body>
</html>

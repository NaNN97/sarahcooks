<?php
$pdo = new PDO("mysql:host=localhost;dbname=sarahcooks", "root", "");
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
$stmt->execute(['id' => $id]);
$recipe = $stmt->fetch();

$imageStmt = $pdo->prepare("SELECT * FROM recipe_images WHERE id = :id");
$imageStmt->execute(['id' => $id]);
$images = $imageStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title><?= htmlspecialchars($recipe['title']) ?> | SarahCooks</title>
</head>
<body>
    <?php include_once('header.php'); ?>

    <div class="recipe-details">
        <h2><?= htmlspecialchars($recipe['title']) ?></h2>
        <h3><?= htmlspecialchars($recipe['subtitle']) ?></h3>
        <p><strong>Cooking Time:</strong> <?= htmlspecialchars($recipe['cooking_time']) ?> minutes</p>
        <p><strong>Servings:</strong> <?= htmlspecialchars($recipe['serving']) ?></p>
        <p><strong>Calories:</strong> <?= htmlspecialchars($recipe['calories']) ?> kcal</p>
        <p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
        <h3>Ingredients</h3>
        <p><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
        <h3>Instructions</h3>
        <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>

        <h3>Images</h3>
        <div class="recipe-images">
            <?php foreach ($images as $image): ?>
                <img src="<?= htmlspecialchars($image['image_path']) ?>" alt="Recipe Image">
            <?php endforeach; ?>
        </div>
    </div>

    <?php include_once('footer.php')?>
</body>
</html>

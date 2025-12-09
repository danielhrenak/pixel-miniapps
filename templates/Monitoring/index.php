<?php
/**
 * @var array $screens
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Screens</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        .button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>Monitoring Screens</h1>
<?php foreach ($screens as $screen): ?>
    <a href="/tv/<?= h($screen['id']) ?>" class="button" target="_blank">
        <?= h($screen['title']) ?>
    </a>
<?php endforeach; ?>
</body>
</html>

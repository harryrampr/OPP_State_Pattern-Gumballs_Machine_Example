<?php declare(strict_types=1);
require_once __DIR__ . '/../../vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/main.css" rel="stylesheet">
</head>
<body>
<div class="container m-6">
    <?php require_once __DIR__ . '/../src/runGumballs.php'; ?>
</div>
</body>
</html>
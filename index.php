<?php 
    include_once __DIR__ . '/Controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logs to Google Sheets</title>
</head>
<body>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        Select Log File: <input name="log_file" type="file" />
        <input type="submit" value="Upload" />
    </form>
</body>
</html>
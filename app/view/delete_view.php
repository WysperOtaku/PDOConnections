<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>
<body>
    <h1>Borrar usuario</h1>
    <form action="/index.php?action=delete" method="POST">
    <label>ID
        <input type="number" name="id" required min="1" step="1">
    </label>
    <br>
    <button type="submit">Borrar</button>
    </form>
</body>
</html>
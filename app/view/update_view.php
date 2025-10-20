<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>
<body>
    <h1>Actualizar usuario</h1>
    <form action="/index.php?action=update" method="POST">
    <label>ID (no se modifica, solo identifica)
        <input type="number" name="id" required min="1" step="1">
    </label>
    <br>
    <label>Nombre (nuevo)
        <input type="text" name="nombre" required minlength="1" maxlength="100">
    </label>
    <br>
    <label>Email (nuevo)
        <input type="email" name="email" required maxlength="190">
    </label>
    <br>
    <button type="submit">Actualizar</button>
    </form>
</body>
</html>
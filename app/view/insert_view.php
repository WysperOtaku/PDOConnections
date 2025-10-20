<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar</title>
</head>
<body>
    <h1>Crear usuario</h1>
    <form action="/index.php?action=create" method="POST" autocomplete="off">
    <label>Nombre
        <input type="text" name="nombre" required minlength="1" maxlength="100">
    </label>
    <br>
    <label>Email
        <input type="email" name="email" required maxlength="190">
    </label>
    <br>
    <button type="submit">Crear</button>
    </form>
</body>
</html>
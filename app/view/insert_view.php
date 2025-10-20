<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar</title>
</head>
<body>
    <h1>Crear usuario</h1>
    <form method="POST">
    <label>Nombre
        <input type="text" name="nombre" required minlength="1" maxlength="100">
    </label>
    <br>
    <label>Apellido
        <input type="text" name="apellido" required minlength="1" maxlength="100">
    </label>
    <br>
    <label>Email
        <input type="email" name="email" required maxlength="190">
    </label>
    <br>
    <button type="submit" name="create">Crear</button>
    </form>
</body>
</html>
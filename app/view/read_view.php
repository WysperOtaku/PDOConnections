<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read</title>
</head>
<body>
    <h1>Buscar usuarios</h1>
    <form action="/index.php?action=search" method="GET" autocomplete="off">
    <input type="hidden" name="action" value="search">
    <label>Nombre contiene
        <input type="text" name="q_nombre" minlength="1" maxlength="255">
    </label>
    <br>
    <label>Email contiene
        <input type="text" name="q_email" minlength="1" maxlength="255">
    </label>
    <br>
    <button type="submit">Buscar</button>
    </form>
</body>
</html>
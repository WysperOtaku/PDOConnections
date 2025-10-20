<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>
<body>
    <h1>Actualizar usuario</h1>
    <form method="POST">
    <label>ID (no se modifica, solo identifica)
        <input type="number" name="id" required min="1">
    </label>
    <br>
    <label>Nombre (nuevo)
        <input type="text" name="nombre" required minlength="1" maxlength="100">
    </label>
    <br>
    <label>Apellido (nuevo)
        <input type="text" name="apellido" required minlength="1" maxlength="100">
    </label>
    <br>
    <label>Email (nuevo)
        <input type="email" name="email" required maxlength="190">
    </label>
    <br>
    <button type="submit" name="update">Actualizar</button>
    </form>

    <?php if (empty($usuarios)): ?>
    <p>No hay usuarios.</p>
    <?php else: ?>
    <table cellpadding="6">
    <thead>
        <tr>
        <th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= $u->getId() ?></td>
            <td><?= htmlspecialchars($u->getNombre(), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($u->getApellido(), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($u->getEmail(),  ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
    <?php endif; ?>
</body>
</html>
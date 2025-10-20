<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read</title>
</head>
<body>
    <h1>Buscar usuarios</h1>
    <form method="POST">
    <br>
    <label>ID de usuario
        <input type="number" name="q_id" min="1">
    </label>
    <br>
    <button type="submit" name="buscar_id">Buscar</button>
    <button type="submit" name="buscar_todos">Listar todos</button>
    </form>
    
    <?php /** @var User $u */ ?>
    <?php if(!empty($u)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($u->getId()) ?></td>
                    <td><?= htmlspecialchars($u->getNombre()) ?></td>
                    <td><?= htmlspecialchars($u->getApellido()) ?></td>
                    <td><?= htmlspecialchars($u->getEmail()) ?></td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
    <?php endif; ?>
</body>
</html>
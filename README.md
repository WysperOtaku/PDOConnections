
# Mini CRUD de Usuarios (PHP + PDO + MySQL)

Aplicación web **sencilla** que implementa un CRUD de usuarios usando **PHP 8**, **PDO** y **MySQL**. Pensada para entorno local con **XAMPP**.

---

## 🧰 Requisitos

- XAMPP (Apache + MySQL) instalado.
- PHP 8.x (incluido en XAMPP recientes).
- Navegador web.
- (Opcional) Editor/IDE (VS Code, PhpStorm…).

---

## 🚀 Despliegue local con XAMPP

1. **Inicia servicios**
   - Abre el panel de XAMPP y arranca **Apache** y **MySQL**.

2. **Importa la base de datos**
   - Entra en **phpMyAdmin**: `http://localhost/phpmyadmin/`
   - Ve a **Importar** y selecciona el fichero **`app/database/schema.sql`** del proyecto.
   - Ejecuta la importación (creará tablas necesarias, p.ej. `usuarios`).

3. **Configura credenciales de conexión**
   - En local, **puede servir**:
     - usuario: `root`
     - contraseña: *(vacía)* `''`
   - Usa el **nombre de la base de datos** que creaste en phpMyAdmin (la misma que importaste en el paso anterior).
   - Crea el archivo de configuración (dos opciones, elige una):  

   **A) Archivo PHP (recomendado, simple)**
   - Copia `config/config.dist.php` → `config/config.php` y edítalo:
     ```php
     <?php
     return [
         'host'    => 'localhost',
         'port'    => 3306,
         'name'    => 'mi_bd', // <-- tu BD
         'user'    => 'root',  // <-- tu usuario
         'pass'    => '',      // <-- '' en local por defecto
         'charset' => 'utf8mb4',
     ];
     ```

4. **Coloca el proyecto en htdocs**
   - Copia la carpeta del proyecto a `C:\xampp\htdocs\mi-crud` (Windows) o a `~/xampp/htdocs/mi-crud` (según tu sistema).

5. **Abre en el navegador**
   - `http://localhost/mi-crud/`.

---

## 🧱 Estructura (orientativa)

```
PDOCONNECTIONS/
├─ app/
│  ├─ controller/
│  │  └─ UserService.php          # Capa de aplicación (coordina el CRUD)
│  │
│  ├─ database/
│  │  └─ scheme.sql               # Esquema MySQL para importar en phpMyAdmin
│  │
│  ├─ model/
│  │  └─ dao/
│  │     └─ UserDAO.php           # Acceso a datos (consultas a la BD)
│  │
│  ├─ entities/
│  │  ├─ User.php                 # Entidad de dominio (modelo User)
│  │  ├─ db-connection.php        # Clase de conexión PDO
│  │  └─ exceptions.php           # Excepciones personalizadas
│  │
│  └─ view/
│     ├─ delete_view.php          # Vista: borrar usuario
│     ├─ initial_view.php         # Vista inicial (menú o index)
│     ├─ insert_view.php          # Vista: crear usuario
│     ├─ list_all_view.php        # Vista: listar usuarios
│     ├─ read_view.php            # Vista: buscar usuario
│     └─ update_view.php          # Vista: actualizar usuario
│
├─ config/
│  ├─ conf.php                    # Config real (NO versionar)
│  └─ config.dist.php             # Plantilla de configuración (versionable)
│
├─ public/
│  └─ style/
│     └─ style.css                # Estilos CSS
│
├─ index.php                      # Punto de entrada principal (router/controlador base)
├─ .gitignore
├─ LICENSE
└─ README.md

```

> **Nota**: `config.php` **no** se debe versionar. Añade a `.gitignore`.

---

## 🔌 Configuración de la conexión (ejemplo)

`infrastructure/Conexion.php` suele leer `config/config.php` y crear el objeto PDO:

```php
<?php
final class Conexion {
  private PDO $pdo;

  public function __construct(?array $cfg = null) {
    if ($cfg === null) {
      $cfg = require __DIR__ . '/../config/config.php';
      $cfg = $cfg['db'];
    }
    $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
      $cfg['host'], $cfg['port'], $cfg['name'], $cfg['charset']
    );
    $this->pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
  }

  public function getConexion(): PDO { return $this->pdo; }
}
```

---

## 🧭 Uso de la app

- **Página inicial**: enlaces a crear, listar/buscar, actualizar y borrar usuarios.

El `index.php` actúa como **router** y delega en `UserService`, que a su vez usa `UserDAO`.

---

## 🧪 Qué hace el CRUD

- **Crear**: Inserta `nombre`, `apellido`, `email` (y genera `user_id` autoincremental).
- **Leer**: Buscar por `id` o filtrar por `nombre/email`. Listar todos.
- **Actualizar**: Cambia `nombre`, `apellido`, `email` por `id` (el `id` **no** se actualiza).
- **Borrar**: Elimina por `id`.

Reglas típicas aplicadas:
- Prepared statements con PDO.
- Transacciones (en operaciones que lo requieran).
- Excepciones de **dominio** (p.ej. email en uso) vs **infraestructura** (errores de BD).

---

## ⚠️ Notas y problemas comunes

- **Credenciales locales**:
  - XAMPP por defecto: `user = root`, `pass = ''` (vacío).
  - Cambia la BD en el config para que coincida con la importada en phpMyAdmin.

- **“Class not found” con `fetchAll(PDO::FETCH_CLASS, User::class)`**  
  Asegúrate de **incluir la clase** antes o usar un autoloader:
  ```php
  require_once __DIR__ . '/../domain/User.php';
  ```
  Si usas namespaces, ajusta `use App\Domain\User;` o `\App\Domain\User::class`.

- **“Cannot redeclare class … / DomainException”**  
  No declares `DomainException` si usas la SPL nativa. Extiende con barra invertida:
  ```php
  class EmailInUse extends \DomainException {}
  class DbError extends \RuntimeException {}
  ```

- **Constructores en entidades y `FETCH_CLASS`**  
  `fetchObject()/FETCH_CLASS` invocan el constructor **sin argumentos**.  
  Si tu `User` tiene constructor con parámetros obligatorios, **construye objetos manualmente** con `FETCH_ASSOC`.

---

## 🔒 Seguridad (mínimos)

- No subas `config.php` con contraseñas al repositorio.
- Escapa siempre la salida en vistas: `htmlspecialchars($valor, ENT_QUOTES, 'UTF-8')`.
- Usa `utf8mb4` y `ATTR_EMULATE_PREPARES = false`.

---

## 📄 Licencia

Uso educativo. Ajusta a tus necesidades.

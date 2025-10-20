<?php
    require_once './app/model/db-connection.php';
    require_once './app/model/entities/User.php';
    require_once './app/model/dao/UserDAO.php';
    require_once './app/controller/UserService.php';
    require_once './app/model/exceptions.php';
    
    $conf = require_once './config/conf.php';

    try {
        $con = new Connection($conf);
        $service = new UserService(new UserDAO($con), $con);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST["insert_form"])) {
                require_once("./app/view/insert_view.php");
            }
            else if (isset($_POST["update_form"])) {
                $usuarios = $service->searchAllUsers();
                require_once("./app/view/update_view.php");
            }
            else if (isset($_POST["delete_form"]))  {
                $usuarios = $service->searchAllUsers();
                require_once("./app/view/delete_view.php");
            }
            else if (isset($_POST["read_form"])) {
                require_once("./app/view/read_view.php");
            }
            else if (isset($_POST["buscar_todos"])) { 
                $usuarios = $service->searchAllUsers();
                require_once("./app/view/list_all_view.php");
            }
            else if (isset($_POST["buscar_id"])) {
                if (!empty($_POST["q_id"]))
                $u = $service->searchUser((int)$_POST["q_id"]);
                require_once("./app/view/read_view.php");
            }
            else if (isset($_POST["create"])) {
                $service->createUser($_POST["nombre"], $_POST["apellido"], $_POST["email"]);
                require_once "./app/view/insert_view.php";
                echo("Usuario creado.");
            }
            else if (isset($_POST["update"])) {
                $service->updateUser($_POST["id"], $_POST["nombre"], $_POST["apellido"], $_POST["email"]);
                $usuarios = $service->searchAllUsers();
                echo("Usuario actualizado");
                require_once("./app/view/update_view.php");
            }
            else if (isset($_POST["delete"])) {
                if (!empty($_POST["q_id"]))
                $service->deleteUser((int)$_POST["q_id"]);
                $usuarios = $service->searchAllUsers();
                echo("Usuario eliminado");
                require_once("./app/view/delete_view.php");
            }
        }
        else {
            require './app/view/initial_view.php';
        }
    } catch (EmailInUseException $e) {
        http_response_code(409);
        echo("409 Conflicto: Email en uso");
    } catch (UserNotFoundException $e) {
        http_response_code(404);
        echo("404 Not found: El usuario buscado no se pudo encontrar");
    } catch (DomainException $e) {
        http_response_code(400);
        echo("400 Error de cliente: Datos introducidos invalidos");
    } catch (InfraestructureException $e) {
        http_response_code(500);
        echo("500 Error del servidor: compruebe el estado del servidor");
        echo("<br>Mensaje de error: " . $e->getMessage());
    } catch (Throwable $e) {
        http_response_code(500);
        echo("Error inesperado, este error no se esperaba, porfavor reporte este error");
        echo("<br>Mensaje de error: " . $e->getMessage());
    }
?>
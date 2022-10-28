<?php
header('Content-Type: application/json');
$metodo = $_SERVER['REQUEST_METHOD'];
switch ($metodo) {
    case 'GET':
        //Realizar el servicio para consultar a todos los personajes registrados
        if ($_GET['accion'] == 'personaje') {
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=kof;charset=utf8","root","root");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            if (isset($_GET['id'])) { 
                $pstm = $conexion->prepare('SELECT * FROM personaje WHERE id = :n');
                $pstm->bindParam(':n', $_GET['id']);
                $pstm->execute();
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
                if ($rs != null) {
                    echo json_encode($rs[0], JSON_PRETTY_PRINT);
                } else {
                    echo "No se encontraron coincidencias";
                }
            } else {
                $pstm = $conexion->prepare('SELECT P.*
                FROM personaje p INNER JOIN magia ma ON p.magia_id = ma.id;');
                $pstm->execute();
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($rs, JSON_PRETTY_PRINT);
            }
        }
        // Realizar el servicio para consultar a un solo personaje incluyendo los Tipos de magia y Tipo de lucha
        if ($_GET['accion'] == 'personajeid') {
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=kof;charset=utf8","root","root");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            if (isset($_GET['id'])) { 
                $pstm = $conexion->prepare('SELECT * FROM personaje WHERE id = :n');
                $pstm->bindParam(':n', $_GET['id']);
                $pstm->execute();
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
                if ($rs != null) {
                    echo json_encode($rs[0], JSON_PRETTY_PRINT);
                } else {
                    echo "No se encontraron coincidencias";
                }
            } else {
                $pstm = $conexion->prepare('SELECT P.*
                FROM personaje p INNER JOIN magia ma ON p.magia_id = ma.id;');
                $pstm->execute();
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($rs, JSON_PRETTY_PRINT);
            }
        }



        // Realizar el servicio para consultar los tipos de magia registrados
        if ($_GET['accion'] == 'magia') {
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "root");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $pstm = $conexion->prepare('SELECT * FROM magia;');
            $pstm->execute();
            $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($rs, JSON_PRETTY_PRINT);
        }
        // Realizar el servicio para consultar los tipos de lucha registrados.
        if ($_GET['accion'] == 'tipo_lucha') {
            try {
                $conexion = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "root");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $pstm = $conexion->prepare('SELECT * FROM tipo_lucha;');
            $pstm->execute();
            $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($rs, JSON_PRETTY_PRINT);
        }
        exit();
        break;
        // Realizar el servicio para registrar nuevos jugadores
        case 'POST':
            if ($_GET['accion'] == 'personaje') {
                $jsonData = json_decode(file_get_contents("php://input"));
                try {
                    $conn = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "root");
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ////INSERT `personaje` (`name`, `lastname`, `birthday`, `utiliza_magia`, `estatura`, `peso`, `equipo`, `magia_id`, `tipo_lucha_id`) VALUES ('Noe', 'Merida', '2003-02-14', '1', '1.70', '80', '1', '1', '1');
                $query = $conn->prepare('INSERT INTO personaje (`name`, `lastname`, `birthday`, `utiliza_magia`, `estatura`, `peso`, `equipo`, `magia_id`, `tipo_lucha_id`) 
                VALUES (:name, :lastname, :birthday, :utiliza_magia, :estatura, :peso, :equipo, :magia_id, :tipo_lucha_id)');
                $query->bindParam(":name", $jsonData->name);
                $query->bindParam(":lastname", $jsonData->lastname);
                $query->bindParam(":birthday", $jsonData->birthday);
                $query->bindParam(":utiliza_magia", $jsonData->utiliza_magia);
                $query->bindParam(":estatura", $jsonData->estatura);
                $query->bindParam(":peso", $jsonData->peso);
                $query->bindParam(":equipo", $jsonData->equipo);
                $query->bindParam(":magia_id", $jsonData->magia_id);
                $query->bindParam(":tipo_lucha_id", $jsonData->tipo_lucha_id);
                $result = $query->execute();
                if ($result) {
                    $_POST["error"] = false;
                    $_POST["message"] = "Registrado correctamente";
                    $_POST["status"] = 200;
                } else {
                    $_POST["error"] = true;
                    $_POST["message"] = "Error al registrar";
                    $_POST["status"] = 400;
                }
                echo json_encode(($_POST));
            }
            break;

            // Realizar el servicio para actualizar los datos de un personaje
            case 'POST':
                if ($_GET['accion'] == 'personaje') {
                    $jsonData = json_decode(file_get_contents("php://input"));
                    try {
                        $conn = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "root");
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    //UPDATE `kof`.`personaje` SET `name` = 'Alan', `lastname` = 'Dominguez', `birthday` = '2003-12-30', `utiliza_magia` = '0', `estatura` = '1.76', `peso` = '119', `equipo` = '0', `magia_id` = '2', `tipo_lucha_id` = '2' WHERE (`id` = '1');
                    $query = $conn->prepare('UPDATE `personaje` SET `name` = ;name, `lastname` = ;lastname, `birthday` = ;birthday, `utiliza_magia` = ;utiliza_magia, `estatura` = ;estatura, `peso` = :peso, `equipo` = :equipo, `magia_id` = :magia_id, `tipo_lucha_id` = :tipo_lucha_id WHERE `id` = :id;');
                    $query->bindParam(":name", $jsonData->name);
                    $query->bindParam(":lastname", $jsonData->lastname);
                    $query->bindParam(":birthday", $jsonData->birthday);
                    $query->bindParam(":utiliza_magia", $jsonData->utiliza_magia);
                    $query->bindParam(":estatura", $jsonData->estatura);
                    $query->bindParam(":peso", $jsonData->peso);
                    $query->bindParam(":equipo", $jsonData->equipo);
                    $query->bindParam(":magia_id", $jsonData->magia_id);
                    $query->bindParam(":tipo_lucha_id", $jsonData->tipo_lucha_id);
                    $result = $query->execute();
                    if ($result) {
                        $_POST["error"] = false;
                        $_POST["message"] = "Registrado correctamente";
                        $_POST["status"] = 200;
                    } else {
                        $_POST["error"] = true;
                        $_POST["message"] = "Error al registrar";
                        $_POST["status"] = 400;
                    }
                    echo json_encode(($_POST));
                }
                break;


    default:

        break;
        echo "metodo no soportado.";
        break;
}
?>

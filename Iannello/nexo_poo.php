<?php

require_once './clases/Alumno.php';
use Iannello\Alumno;

$alumno = new Alumno(0, "-", "-", "-");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["accion"])){
        $accion = $_POST["accion"];

        switch($accion){
            case "agregar":
                if(isset($_POST["nombre"],  $_POST["apellido"], $_POST["legajo"], $_FILES["foto"])){
                    $nombre = $_POST["nombre"];
                    $apellido = $_POST["apellido"];
                    $legajo = $_POST["legajo"];
                    $foto = $_FILES["foto"];

                    $resultado = $alumno->agregar($legajo, $nombre, $apellido, $foto);

                    echo $resultado;
                } else {
                    echo "Datos incompletos para agregar al alumno.";
                }
                break;
            
            case "verificar":
                if(isset($_POST["legajo"])){
                    $legajoABuscar = $_POST["legajo"];

                    $resultado = $alumno->verificar($legajoABuscar);

                    echo $resultado;
                } else {
                    echo "Legajo no proporcionado.";
                }
                break;

            case "modificar":
                if(isset($_POST["legajo"], $_POST["nombre"], $_POST["apellido"], $_FILES["foto"])){
                    $legajo = $_POST["legajo"];
                    $nombreNuevo = $_POST["nombre"];
                    $apellidoNuevo = $_POST["apellido"];
                    $fotoNueva = $_FILES["foto"];

                    $resultado = $alumno->modificar($legajo, $nombreNuevo, $apellidoNuevo, $fotoNueva);

                    echo $resultado;
                } else {
                    echo "Datos incompletos para modificar al alumno.";
                }
                break;

            case "borrar":
                if(isset($_POST["legajo"])){
                    $legajo = $_POST["legajo"];

                    $resultado = $alumno->borrar($legajo);

                    echo $resultado;
                } else {
                    echo "Legajo no propocionado.";
                }
                break;

            case "obtener":
                if(isset($_POST["legajo"])){
                    $legajoABuscar = $_POST["legajo"];
                    $alumnoEncontrado = $alumno->obtenerAlumnoPorLegajo($legajoABuscar);

                    if($alumnoEncontrado != null){
                        var_dump($alumnoEncontrado);
                    } else {
                        echo "No se pudo encontrar al alumno.";
                    }
                } else {
                    echo "Legajo no proporcionado.";
                }
                break;

            case "redirigir":
                if(isset($_POST["legajo"])){
                    $legajo = $_POST["legajo"];

                    $resultado = $alumno->verificar($legajo);

                    if(strpos($resultado, "NO") !== false){
                        echo $resultado;
                    } else {
                        session_start();

                        $_SESSION["legajo"] = $legajo;
                        $_SESSION["nombre"] = $alumno->obtenerNombrePorLegajo($legajo);
                        $_SESSION["apellido"] = $alumno->obtenerApellidoPorLegajo($legajo);
                        $_SESSION["foto"] = $alumno->obtenerFotoPorLegajo($legajo);

                        header("Location: principal.php");
                        exit;
                    }
                } else {
                    echo "Legajo no propocionado.";
                }
                break;
            
            default:
                echo "Accion no valida.";
        }
    } else {
        echo "Accion no proporcionada.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["accion"])){
        $accion = $_GET["accion"];

        switch($accion){
            case "listar":
                $resultado = $alumno->listar();

                echo $resultado;
                break;
            
            default:
                echo "Accion no valida.";
        }
    } else {
        echo "Accion no proporcionada.";
    }
}

?>
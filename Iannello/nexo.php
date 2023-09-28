<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["accion"]) && $_GET["accion"] == "listar") {
        $archivoAlumnos = "./archivos/alumnos_foto.txt";

        if (file_exists($archivoAlumnos)) {
            $contenido = file($archivoAlumnos, FILE_IGNORE_NEW_LINES);

            if ($contenido === false) {
                echo "No se pudo leer el archivo.";
            } else {
                echo "<h2>Lista de Alumnos</h2>";
                echo "<ul>";

                foreach ($contenido as $linea) {
                    list($legajo, $apellido, $nombre) = explode(" - ", $linea);
                    echo "\n<li>Legajo: $legajo - Apellido: $apellido - Nombre: $nombre</li>";
                }

                echo "</ul>";
            }
        } else {
            echo "El archivo no existe.";
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["accion"])) {
        if ($_POST["accion"] == "agregar") {
            if (isset($_POST["nombre"], $_POST["apellido"], $_POST["legajo"])) {
                $nombre = $_POST["nombre"];
                $apellido = $_POST["apellido"];
                $legajo = $_POST["legajo"];

                $linea = "$legajo - $apellido - $nombre\n";

                if ($archivo = fopen("./archivos/alumnos_foto.txt", "a")) {
                    if (fwrite($archivo, $linea)) {
                        echo "El alumno se ha guardado correctamente.";
                    } else {
                        echo "No se pudo guardar el alumno.";
                    }

                    fclose($archivo);
                } else {
                    echo "No se pudo abrir el archivo.";
                }
            } else {
                echo "Datos incompletos para agregar el alumno.";
            }
        } elseif ($_POST["accion"] == "verificar") {
            if (isset($_POST["legajo"])) {
                $legajoABuscar = $_POST["legajo"];
                $archivoAlumnos = "./archivos/alumnos_foto.txt";

                if (file_exists($archivoAlumnos)) {
                    $contenido = file($archivoAlumnos, FILE_IGNORE_NEW_LINES);

                    if ($contenido === false) {
                        echo "No se pudo leer el archivo.";
                    } else {
                        $encontrado = false;

                        foreach ($contenido as $linea) {
                            list($legajo, $apellido, $nombre) = explode(" - ", $linea);

                            if ($legajo == $legajoABuscar) {
                                echo "El alumno con legajo: $legajoABuscar se encuentra en la lista.";
                                $encontrado = true;
                                break;
                            }
                        }

                        if (!$encontrado) {
                            echo "El alumno con legajo: $legajoABuscar NO se encuentra en la lista.";
                        }
                    }
                } else {
                    echo "El archivo no existe.";
                }
            } else {
                echo "Legajo no proporcionado.";
            }
        } elseif ($_POST["accion"] == "modificar") {
            if (isset($_POST["legajo"], $_POST["nombre"], $_POST["apellido"])) {
                $legajoAModificar = $_POST["legajo"];
                $nombreNuevo = $_POST["nombre"];
                $apellidoNuevo = $_POST["apellido"];
                $archivoAlumnos = "./archivos/alumnos_foto.txt";

                $linea = "$legajoAModificar - $apellidoNuevo - $nombreNuevo\n";

                if (file_exists($archivoAlumnos)) {
                    $contenido = file($archivoAlumnos, FILE_IGNORE_NEW_LINES);

                    if ($contenido === false) {
                        echo "No se pudo leer el archivo.";
                    } else {
                        $encontrado = false;

                        foreach ($contenido as $clave => $linea) {
                            list($legajo, $apellido, $nombre) = explode(" - ", $linea);

                            if ($legajo == $legajoAModificar) {
                                $linea = "$legajo - $apellidoNuevo - $nombreNuevo";
                                $contenido[$clave] = $linea;
                                $encontrado = true;
                                echo "El alumno con legajo $legajoAModificar se ha modificado correctamente.";
                                break;
                            }
                        }

                        if (!$encontrado) {
                            echo "El alumno con legajo $legajoAModificar no se encuentra en el listado";
                        }

                        file_put_contents($archivoAlumnos, implode("\n", $contenido));
                    }
                } else {
                    echo "El archivo no existe.";
                }
            } else {
                echo "Datos incompletos para la modificación.";
            }
        } elseif ($_POST["accion"] == "borrar") {
            if (isset($_POST["legajo"])) {
                $legajoABorrar = $_POST["legajo"];
                $archivoAlumnos = "./archivos/alumnos_foto.txt";

                if (file_exists($archivoAlumnos)) {
                    $contenido = file($archivoAlumnos, FILE_IGNORE_NEW_LINES);

                    if ($contenido === false) {
                        echo "No se pudo leer el archivo.";
                    } else {
                        $encontrado = false;

                        foreach ($contenido as $clave => $linea) {
                            list($legajo, $apellido, $nombre) = explode(" - ", $linea);

                            if ($legajo == $legajoABorrar) {
                                unset($contenido[$clave]);
                                $encontrado = true;
                                echo "El alumno con legajo $legajoABorrar se ha borrado.";
                                break;
                            }
                        }

                        if (!$encontrado) {
                            echo "El alumno con legajo $legajoABorrar no se encuentra en el listado.";
                        }

                        file_put_contents($archivoAlumnos, implode("\n", $contenido));
                    }
                } else {
                    echo "El archivo no existe.";
                }
            } else {
                echo "Legajo no proporcionado.";
            }
        } else {
            echo "Acción no válida.";
        }
    } else {
        echo "Acción no especificada.";
    }
} else {
    echo "Acceso no válido.";
}
?>
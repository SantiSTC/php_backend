<?php
    namespace Iannello;

    class Alumno {
        public $legajo;
        public $nombre;
        public $apellido;
        public $foto;

        private $archivoAlumnos = "./archivos/alumnos_foto.txt";
        private $archivoFotos = "./fotos/";

        public function __construct($legajo, $nombre, $apellido, $foto)
        {
            $this->legajo = $legajo;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->foto = $foto;
        }

        public function agregar($legajo, $nombre, $apellido, $foto){
            $extension = pathinfo($foto["name"], PATHINFO_EXTENSION);
            $nombreArchivoFoto = "$legajo.$extension";

            $this->setFoto($legajo, $foto);

            $linea = "$legajo - $apellido - $nombre - $nombreArchivoFoto\n";

            if($archivo = fopen($this->archivoAlumnos, "a")){
                if(fwrite($archivo, $linea)){
                    fclose($archivo);
                    return "El alumno se agregó correctamente.";
                } else {
                    fclose($archivo);
                    return "No se pudo agregar al alumno.";
                }
            } else {
                return "No se pudo abrir el archivo.";
            }
        }

        public function verificar($legajoABuscar){
            if(file_exists($this->archivoAlumnos)){
                $contenido = file($this->archivoAlumnos, FILE_IGNORE_NEW_LINES);

                if($contenido === false){
                    return "No se pudo leer el archivo.";
                } else {
                    foreach ($contenido as $linea) {
                        list($legajo, $apellido, $nombre, $foto) = explode(" - ", $linea);

                        if($legajo == $legajoABuscar){
                            return "El alumno con legajo: $legajoABuscar se encuentra en la lista.";
                        }
                    }
                    return "El alumno con legajo: $legajoABuscar NO se encuentra en la lista.";
                }
            } else {
                return "El archivo no existe.";
            }
        }

        public function modificar($legajoAModificar, $nombreNuevo, $apellidoNuevo, $fotoNueva){
            if(file_exists($this->archivoAlumnos)){
                $contenido = file($this->archivoAlumnos, FILE_IGNORE_NEW_LINES);

                if($contenido === false){
                    return "No se pudo leer el archivo.";
                } else {
                    $encontrado = false;

                    foreach($contenido as $clave => $linea){
                        list($legajo, $apellido, $nombre, $foto) = explode(" - ", $linea);

                        if($legajo == $legajoAModificar){
                            $extension = pathinfo($fotoNueva["name"], PATHINFO_EXTENSION);
                            $nombreArchivoFoto = "$legajoAModificar.$extension";

                            $this->borrarFoto($legajoAModificar);
                            $this->setFoto($legajoAModificar, $fotoNueva);

                            $contenido[$clave] = "$legajo - $apellidoNuevo - $nombreNuevo - $nombreArchivoFoto";
                            $encontrado = true;
                            file_put_contents($this->archivoAlumnos, implode("\n", $contenido) . "\n");
                            return "El alumno con legajo: $legajoAModificar se ha modificado correctamente.";
                        }
                    }

                    if(!$encontrado){
                        return "El alumno con legajo: $legajoAModificar NO se ha encontrado.";
                    }
                }
            } else {
                return "El archivo no existe.";
            }
        }

        public function borrar($legajoABorrar){
            if(file_exists($this->archivoAlumnos)){
                $contenido = file($this->archivoAlumnos, FILE_IGNORE_NEW_LINES);

                if($contenido === false){
                    return "No se pudo leer el archivo.";
                } else {
                    $encontrado = false;

                    foreach ($contenido as $clave => $linea) {
                        list($legajo, $apellido, $nombre, $foto) = explode(" - ", $linea);
                        
                        if($legajo == $legajoABorrar){
                            $this->borrarFoto($legajoABorrar);
                            unset($contenido[$clave]);
                            $encontrado = true;
                            file_put_contents($this->archivoAlumnos, implode("\n", $contenido) . "\n");
                            return "El alumno con legajo: $legajoABorrar se ha eliminado correctamente.";
                        }
                    }

                    if(!$encontrado){
                        return "El alumno con legajo: $legajoABorrar NO se ha encontrado.";
                    }
                }
            } else {
                return "El archivo no existe.";
            }
        }

        public function listar(){
            if(file_exists($this->archivoAlumnos)){
                $contenido = file($this->archivoAlumnos, FILE_IGNORE_NEW_LINES);

                if($contenido === false){
                    return "No se pudo leer el archivo.";
                } else {
                    $resultados = [];

                    foreach($contenido as $linea){
                        list($legajo, $apellido, $nombre, $foto) = explode(" - ", $linea);

                        $pathFoto = $this->getFoto($legajo);

                        $resultados[] = [
                            'legajo' => $legajo,
                            'apellido' => $apellido,
                            'nombre' => $nombre,
                            'foto' => $pathFoto,
                        ];
                    }

                    return json_encode($resultados);
                }
            }
        }

        public function setFoto($legajo, $foto){
            $extension = "jpg";

            if(!file_exists($this->archivoFotos)){
                mkdir($this->archivoFotos, 0777, true);
            }

            $nombreArchivo = $legajo . "." . $extension;
            $pathArchivo = $this->archivoFotos . $nombreArchivo;

            if(move_uploaded_file($foto["tmp_name"], $pathArchivo)){
                $this->actualizarArchivoFotos($legajo, $nombreArchivo);
            } else {
                echo "Error al subir la foto.";
            }
        }

        public function getFoto($legajo){
            $nombreArchivo = $legajo . ".jpg";
            $pathArchivo = $this->archivoFotos . $nombreArchivo;

            if(file_exists($pathArchivo)){
                return $pathArchivo;
            } else {
                return "ERROR. No se ha encontrado la ruta a la foto indicada.";
            }
        }

        private function actualizarArchivoFotos($legajo, $nombreArchivo){
            $archivoAlumnosFotos = "./archivos/alumnos_foto.txt";

            if(file_exists($archivoAlumnosFotos)){
                $contenido = file($archivoAlumnosFotos, FILE_IGNORE_NEW_LINES);
                
                if($contenido !== false){
                    foreach($contenido as $clave => $linea){
                        $datos = explode(" - ", $linea);

                        if($datos[0] == $legajo){
                            $contenido[$clave] = "$legajo - {$datos[1]} - {$datos[2]} - $nombreArchivo";
                            break;
                        }
                    }

                    file_put_contents($archivoAlumnosFotos, implode("\n", $contenido) . "\n");
                } else {
                    echo "No se pudo leer el archivo en $archivoAlumnosFotos.";
                }
            } else {
                echo "El archivo de $archivoAlumnosFotos no existe.";
            }
        }

        private function borrarFoto($legajo){
            $pathFoto = $this->archivoFotos . "$legajo.jpg";

            if(file_exists($pathFoto)){
                unlink($pathFoto);
            }
        }

        public function obtenerAlumnoPorLegajo($legajoAObtener){
            if(file_exists($this->archivoAlumnos)){
                $contenido = file($this->archivoAlumnos, FILE_IGNORE_NEW_LINES);

                if($contenido === false){
                    return null;
                } else {
                    foreach($contenido as $linea){
                        list($legajo, $apellido, $nombre, $foto) = explode(" - ", $linea);

                        if($legajo == $legajoAObtener){
                            return new Alumno($legajo, $apellido, $nombre, $foto);
                        }
                    }

                    return null;
                }
            } else {
                return null;
            }
        }

        public function obtenerNombrePorLegajo($legajoABuscar){
            if(file_exists($this->archivoAlumnos)){
                $contenido = file($this->archivoAlumnos, FILE_IGNORE_NEW_LINES);

                if($contenido === false){
                    return null;
                } else {
                    foreach($contenido as $linea){
                        list($legajo, $apellido, $nombre, $foto) = explode(" - ", $linea);

                        if($legajo == $legajoABuscar){
                            return $nombre;
                        }
                    }

                    return null;
                }
            } else {
                return null;
            }
        }

        public function obtenerApellidoPorLegajo($legajoABuscar){
            if(file_exists($this->archivoAlumnos)){
                $contenido = file($this->archivoAlumnos, FILE_IGNORE_NEW_LINES);

                if($contenido === false){
                    return null;
                } else {
                    foreach($contenido as $linea){
                        list($legajo, $apellido, $nombre, $foto) = explode(" - ", $linea);

                        if($legajo == $legajoABuscar){
                            return $apellido;
                        }
                    }

                    return null;
                }
            } else {
                return null;
            }
        }

        public function obtenerFotoPorLegajo($legajoABuscar){
            if(file_exists($this->archivoAlumnos)){
                $contenido = file($this->archivoAlumnos, FILE_IGNORE_NEW_LINES);

                if($contenido === false){
                    return null;
                } else {
                    foreach($contenido as $linea){
                        list($legajo, $apellido, $nombre, $foto) = explode(" - ", $linea);

                        if($legajo == $legajoABuscar){
                            return $foto;
                        }
                    }

                    return null;
                }
            } else {
                return null;
            }
        }
    }
?>
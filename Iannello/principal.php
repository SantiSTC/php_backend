<?php

require_once './clases/Alumno.php';
use Iannello\Alumno;

session_start();

$alumno = new Alumno(0, "", "", "");

if(!isset($_SESSION["legajo"])){
  header("Location: nexo_poo.php");
  exit();
} else {
  echo "<h1>Legajo: {$_SESSION["legajo"]}</h1><br>
        <h2>Nombre y Apellido: {$_SESSION["nombre"]} {$_SESSION["apellido"]}</h2><br>
        <img src= './fotos/{$_SESSION["foto"]}' alt='Foto del alumno'><br><br><br>";

  echo "<table border='1'> 
        <thead>
        <tr>
        <th>Legajo</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Foto</th>
        </tr>
        </thead>
        <tbody>";

  $alumnos = json_decode($alumno->listar());

  foreach($alumnos as $alumno){
    echo "<tr>
          <td>{$alumno->legajo}</td>
          <td>{$alumno->nombre}</td>
          <td>{$alumno->apellido}</td>
          <td><img src='./fotos/{$alumno->foto}' alt='{$alumno->nombre}'></td>
          </tr>";
  }

  echo "</tbody>
        </table>";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Principal</title>
  </head>
  <body>
      
  </body>
</html>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Alumnos</title>
  </head>
  <body>
  <h2>Cargar alumno</h2>
    <form action="nexo_poo.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="accion" value="agregar">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" required><br>

        <label for="legajo">Legajo:</label>
        <input type="text" name="legajo" id="legajo" required><br>

        <label for="foto">Foto:</label>
        <input type="file" name="foto" id="foto" accept="image/*" required><br>

        <input type="submit" value="Agregar Alumno">
    </form>

    <h2>Verificar alumno por legajo</h2>
    <form action="nexo_poo.php" method="POST" >
        <input type="hidden" name="accion" value="verificar">

        <label for="legajo_verificar">Legajo a Verificar:</label>
        <input type="text" name="legajo" id="legajo_verificar" required>

        <input type="submit" value="Verificar">
    </form>

    <br><br>
    <h2>Listar alumnos</h2>
    <a href="nexo_poo.php?accion=listar" class="listar-btn">Listar Alumnos</a>

    <br><br>
    <h2>Modificar alumno</h2> 
    <form action="nexo_poo.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="accion" value="modificar">

        <label for="legajo_modificar">Legajo a Modificar:</label>
        <input type="text" name="legajo" id="legajo_modificar" required><br>

        <label for="nombre_nuevo">Nuevo Nombre:</label>
        <input type="text" name="nombre" id="nombre_nuevo" required><br>

        <label for="apellido_nuevo">Nuevo Apellido:</label>
        <input type="text" name="apellido" id="apellido_nuevo" required><br>

        <label for="foto_nueva">Nueva Foto:</label>
        <input type="file" name="foto" id="foto_nueva" accept="image/*" required><br>

        <input type="submit" value="Modificar Alumno">
    </form>

    <br><br>
    <h2>Borrar alumno</h2>
    <form action="nexo_poo.php" method="POST">
        <input type="hidden" name="accion" value="borrar">

        <label for="legajo_borrar">Legajo a Borrar:</label>
        <input type="text" name="legajo" id="legajo_borrar" required>

        <input type="submit" value="Borrar Alumno">
    </form>

    <br><br>
    <h2>Obtener Alumno por Legajo</h2>
    <form action="nexo_poo.php" method="POST">
        <input type="hidden" name="accion" value="obtener">

        <label for="legajo_obtener">Legajo a obtener:</label>
        <input type="text" name="legajo" id="legajo_obtener" required>

        <input type="submit" value="Obtener Alumno">
    </form>

    <br><br>
    <h2>Redirigir</h2>
    <form action="nexo_poo.php" method="POST">
        <input type="hidden" name="accion" value="redirigir">

        <label for="legajo_redirigir">Legajo a redirigir:</label>
        <input type="text" name="legajo" id="legajo_redirigir" required>

        <input type="submit" value="Redirigir">
    </form>

  </body>
</html>


<?php
 //include('class/bd.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Prueba</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <!-- Bootstrap core CSS -->

      <div class="container mt-3">
        <div class="row" id="encabezado">
          <div class="col-sm-8 text-left">
            <h3>Lista de Empleados</h3>
          </div>
          <div class="col-sm-4 text-right">
            <button type="button" class="btn btn-primary" id="crear">Crear</button>
          </div>
        </div>
        <div class="" id="contenido">
        </div>
      </div>

      <script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
      <script type="text/javascript" src="js/bootstrap.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/main.js"></script>
      <script type="text/javascript">
        cargar_tabla();
        $("#crear").click(function(){
          crea_empleado();
        });
      </script>
    </body>
</html>

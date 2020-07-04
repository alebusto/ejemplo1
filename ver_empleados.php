<?php
    $titulo_pagina = "Empleados";
    session_start();
    //Se incluye el archivo de conexion
    include ("conexion.php");
    //Se verifica que exista la conexión
    $lista_empleados = [];
    if($connection){                    
        $select = "SELECT * FROM EMPLEADO";
        // Se hace la conversión de la consulta con la conexión
        $variable = oci_parse($connection, $select);                                  
        $estado = @oci_execute($variable);
        if(!$estado){
            $error = oci_error($variable);  
            $resultado = "FALSE";
            $mensaje = $error['message'];
        }
        while (($row = oci_fetch_array($variable, OCI_BOTH)) != false) {
            array_push($lista_empleados, $row);
        }    
        oci_free_statement($variable);                                
        oci_close($connection);
    }else{
        $resultado = "FALSE";
        $mensaje = "Ha ocurrido un error al conectarse a la base de datos";
    }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $titulo_pagina;?></title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.min.js"></script>
</head>
<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal"><a href="../index.php">Proyecto de Prueba</a></h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="ver_empleados.php">Ver Empleados</a>
    </nav>
    <a class="btn btn-outline-primary" href="inicio_sesion.php">Iniciar Sesión</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Empleados Registrados</h1>
    </div>

    <div class="container">
        <?php 
            if(count($lista_empleados) > 0){
        ?>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Rut</th>
                <th scope="col">Nombre</th>
                <th scope="col">Edad</th>
                <th scope="col">Salario</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //La consulta retorna un arreglo de valores que se debe recorrer con oci_fetch
                //Cada valor entre los [] es una columna de la tabla en la base de datos
                for($i = 0; $i < count($lista_empleados); $i++) {
                ?>                        
                    <tr>
                        <td><?php echo $lista_empleados[$i]['RUT']?></td>
                        <td><?php echo $lista_empleados[$i]['NOMBRE']?></td>
                        <td><?php echo $lista_empleados[$i]['EDAD']?></td>
                        <td><?php echo $lista_empleados[$i]['SALARIO']?></td>                                    
                    </tr>
                <?php                                    
                }    
                ?>      
            </tbody>
        </table>
        <?php 
            }else{
        ?>
            <div class="alert alert-info">No hay empleados en la base de datos</div>
        <?php
            }
        ?>

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="/docs/4.3/assets/brand/bootstrap-solid.svg" alt="" width="24" height="24">
                <small class="d-block mb-3 text-muted">&copy; Laboratorio Base de Datos 2020</small>
            </div>        
        </div>
    </footer>
    </div>
</body>
</html>
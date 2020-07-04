<?php
    incio_sesion();
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["rut_usuario"])){
            $rut = $_POST["rut_usuario"];
            $nombre = $_POST["nombre_empleado"];
            $edad = $_POST["edad_usuario"];
            $salario = $_POST["salario_usuario"];
            include("conexion.php");
            if($connection){
                $query = OCIParse($connection, "begin ingresa_empleado(:rut, :nombre, :edad, :salario, :resultado, :mensaje); end;");
                //Los oci_bind se encargar de vincular las variables del php con las del procedimiento
                oci_bind_by_name($query, ':rut', $rut);
                oci_bind_by_name($query, ':nombre',$nombre);
                oci_bind_by_name($query, ':edad',$edad);
                oci_bind_by_name($query, ':salario',$salario);
                //Las siguientes 2 variables son tipo OUT del procedimiento, que retornan el tipo de error y lo que dice el error
                oci_bind_by_name($query, ':resultado',$resultado,100);
                oci_bind_by_name($query, ':mensaje',$mensaje,100);
                //Se ejecuta la consulta luego de hacer el parse y el bind
                //oci_execute al fallar tira un error instantáneo en la vista.
                //Para evitar ese error agregamos el @ antes del oci_execute..
                $sp = @oci_execute($query);
                
                $_SESSION["resultado"] = $resultado;
                $_SESSION["mensaje"] = $mensaje;
                //Se eliminar la consulta realizada a la base de datos
                oci_free_statement($query);
                //Se cierra la conexión
                oci_close($connection);
            }else{
                $_SESSION["resultado"] = "FALSE";
                $_SESSION["mensaje"] = "Ha ocurrido un error al conectarse a la base de datos";
            }
            header("Location: ../index.php");
        }else{
            header("Location: ../index.php");
        }
    }else{
        header("Location: ../index.php");
    }
?>


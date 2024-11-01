<?php 
include ('db.php');

$USUARIO=$_POST['nombre'];
$PASSWORD=$_POST['password'];


$consulta = " SELECT* FROM usuarios  where nombre = '$USUARIO' and password = '$PASSWORD' ";
$resultado= mysqli_query($conn, $consulta);
$filas=mysqli_num_rows($resultado);
if($filas){
    header( "location:home.html");
} else{
    include("inicioSesion.html");
    ?>
    <h1>ERROR DE AUTENTICACION</h1>;
    <?php   
} 
mysqli_free_result($resultado);
mysqli_close($conexion);

?>

    




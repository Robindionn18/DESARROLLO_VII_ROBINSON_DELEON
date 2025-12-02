<?php
require_once "conexion.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
       
    $sql = "DELETE FROM productos WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
         mysqli_stmt_bind_param($stmt, "i", $id);
        
        if(mysqli_stmt_execute($stmt)){
            echo "Se ha eliminado el producto.";
            header("index.php");
        } else{
            echo "ERROR: No se puede eliminar el producto $sql. " . mysqli_error($conn);
        }
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>ID del Producto</label><input type="number" name="id" required></div>
    <input type="submit" value="Eliminar Producto">
</form>
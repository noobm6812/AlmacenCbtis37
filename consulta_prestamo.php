<?php
// Lourdes Soto 

$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "cbtis_prestamos"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT nombreProducto FROM producto"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/consultapres.css">
    <title>Seleccionar Producto</title>
    
</head>
<body>
<header class="Header">
    <a href="menuAdministrador.html" class="logo">
        <img src="img/logo.jpg" class="logo" alt="logo">
    </a>

    <nav class="navbar">
        <ul class="menu">
           
            <li class="item"><a href="registrar_producto.html" class="link">Registrar Producto</a></li>
            <li class="item"><a href="registro.html" class="link">Registrar Usuario</a></li>
            <li class="item"><a href="registrarDevolucion.html" class="link">Registrar Devolución</a></li>
        </ul>
       
    </nav>
</header>

<div class="container">
   <h1>Selecciona un Producto</h1>
    <form action="conphp.php" method="POST"> 
        <label for="producto">Selecciona un producto:</label>
        
        <select name="nombreProducto" id="producto">
            <option value="">Seleccione un producto</option> 
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row["nombreProducto"], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row["nombreProducto"], ENT_QUOTES, 'UTF-8') . "</option>";
                }
            } else {
                echo "<option value=''>No hay productos disponibles</option>";
            }
            ?>
        </select>
        <input type="submit" value="Enviar">
    </form>
</div>

<?php
$conn->close();
?>
 
</body>
</html>

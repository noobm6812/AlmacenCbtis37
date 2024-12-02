<?php
// Lourdes Soto 

$servername = "sql306.infinityfree.com"; 
$username = "if0_37832269";
$password = "Ey5UdLKDyEw";
$dbname = "if0_37832269_cbtis_prestamos";

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
    <title>Préstamos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/prestamos.css">
</head>

<body>
    <header class="Header">
        <a href="menuUsuario.html" class="logo">
            <img src="img/logo.jpg" class="logo" alt="logo">
        </a>

        <nav class="navbar">
            <ul class="menu">
                <li class="item"><a href="Articulos.html" class="link">Artículos</a></li>
                <li class="item"><a href="devoluciones.html" class="link">Devoluciones</a></li>
            </ul>
           

        </nav>
    </header>


    <div class="container">
        <form id="formularioPrestamos">
            <h1>Préstamo</h1>

            <label for="ID">ID:</label>
            <input type="number" id="ID" name="idUsuario" placeholder="ID de usuario" required class="input"
                class="input"><br>

            <label for="producto">Producto:</label><br>
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
        </select><br><br>

            <label for="CantArti">Cantidad de artículos:</label><br>
            <input type="number" name="cantSolicitada" required class="input"><br><br>

            <label for="fechapedido">Fecha de Pedido:</label><br>
            <input type="datetime-local" id="pedido" name="fechaDePedido" readonly class="input"><br><br>

            <label for="fEntrega">Fecha de entrega:</label><br>
            <input type="datetime-local" id="entrega" name="fechaEntrega" readonly class="input"><br><br>

            <button type="submit" class="btn">Aceptar</button>
        </form>
    </div>

    

    <script>
        $(document).ready(function () {
            // Establecer la fecha y hora actuales en los campos de fecha
            var now = new Date();
            var offset = now.getTimezoneOffset() * 60000; // Obtener la diferencia en milisegundos
            var localDate = new Date(now.getTime() - offset); // Ajustar la hora a la zona local
            var fechaActual = localDate.toISOString().slice(0, 16); // Formato YYYY-MM-DDTHH:mm
            $('#pedido').val(fechaActual);
            $('#entrega').val(new Date(localDate.getTime() + 30 * 60000).toISOString().slice(0, 16)); // Sumar 30 minutos

            $('#formularioPrestamos').submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "prestamos.php",
                    data: formData,
                    success: function (response) {
                        console.log(response); // Verificar la respuesta en la consola
                        const data = JSON.parse(response); // Parsear la respuesta JSON
                        if (data.success) {
                            // Mostrar alerta de éxito
                            alert(data.message);
                            $('#contactFormResponse').html('<div class="alert alert-success">' + data.message + '</div>');
                            $('#formularioPrestamos')[0].reset(); // Limpiar el formulario
                        } else {
                            // Mostrar alerta de error
                            alert(data.message);
                            
                        }
                    },
                    error: function () {
                        $('#contactFormResponse').html('<div class="alert alert-danger">Ocurrió un error. Por favor, inténtalo de nuevo.</div>');
                    }
                });
            });
        });
    </script>
    
</body>

</html>
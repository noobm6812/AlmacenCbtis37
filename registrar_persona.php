<?php

//Lourdes Soto
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

$conn->set_charset("utf8");

$correoElectronico = $_POST['correoElectronico'];
$contraseña = $_POST['Contraseña'];
$nombreUsuario = $_POST['nombreUsuario'];
$idAdministrador = $_POST['idAdministrador'];

// Encriptar la contraseña
$contraseñaEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);

// Preparar la consulta
$stmt = $conn->prepare("INSERT INTO usuario (correoElectronico, Contraseña, nombreUsuario, idAdministrador) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Vincular parámetros
$stmt->bind_param("sssi", $correoElectronico, $contraseñaEncriptada, $nombreUsuario, $idAdministrador);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo"<script>
            alert('REGISTRADO EXITOSAMENTE');
            window.location.href = document.referrer; // Redirige a la página anterior
          </script>";
} else {
    echo "<script>
            alert('ERROR AL REGISTRAR');
            window.location.href = document.referrer; // Redirige a la página anterior
          </script>" . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
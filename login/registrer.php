<?php
include("conexion.php");

if (isset($_POST['usuarioNew']) && !empty($_POST['usuarioNew']) && isset($_POST['passwordNew']) && !empty($_POST['passwordNew']) && isset($_POST['correoNew']) && !empty($_POST['correoNew'])) {
    $usuarioNew = $_POST['usuarioNew'];
    $passwordNew = $_POST['passwordNew'];
    $correoNew = $_POST['correoNew'];
    $query = "SELECT * FROM users WHERE username='$usuarioNew'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(array('success' => 1, 'message' => 'Usuario ya existe'));
    } else {
        $insertQuery = "INSERT INTO users (username, password, email) VALUES ('$usuarioNew', '$passwordNew', '$correoNew')";
        if (mysqli_query($conn, $insertQuery)) {
            echo json_encode(array('success' => 2, 'message' => 'Usuario creado exitosamente'));
        } else {
            echo json_encode(array('success' => 0, 'message' => 'Error al crear el usuario'));
        }
    }
}

<?php
include("conexion.php");

if (isset($_POST['correo']) && !empty($_POST['correo'])) {
    $correo = $_POST['correo'];
    $query = "SELECT password FROM users WHERE email='$correo'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        echo json_encode(array('success' => 1, 'message' => 'Correo encontrado', 'password' => $user['password']));
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Correo no encontrado'));
    }
}
?>
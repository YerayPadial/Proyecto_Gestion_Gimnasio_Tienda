//cargo los elementos del DOM
window.addEventListener('load', () => {
    //const del form de registro
    const formReg = document.getElementsByClassName('container-Registro')[0];
    const BtnVolverLog = document.getElementById('VolverLog');

    //formularioo registro
    let buttonR = document.getElementById('formRegistro');
    let usuarioNew = document.getElementById('usuarioNew');
    let passwordNew = document.getElementById('passwordNew');
    let passRepeat = document.getElementById('contrasenaRepetida');
    let alertaR = document.getElementById('alertaFail');
    let correoNew = document.getElementById('correoNew');
    let togglePasswordNew = document.getElementById('togglePasswordNew');

    //const del form de inicio
    const formLog = document.getElementsByClassName('container-Login')[0];
    const BtnCambiarPass = document.getElementById('cambiarPass');
    const Btnregistro = document.getElementById('registrate');

    //Const de el form de cambiar passswd
    const formCambiarPass = document.getElementsByClassName('container-CambiarPass')[0];
    const BtnVolverPass = document.getElementById('volverPas');

    //formularioo login
    let button = document.getElementById('formLogin');
    let usuario = document.getElementById('usuario');
    let password = document.getElementById('password');
    let alert = document.getElementById('alerta');
    console.log(usuario);

    //funcion que envia estos datos mediante fetch
    function data() {
        let datos = new FormData();
        datos.append("usuario", usuario.value);
        datos.append("password", password.value);

        fetch('login.php', {
            method: 'POST',
            body: datos
        })
            .then(response => response.text()) // Cambiar a text() para depurar
            .then(text => {
                console.log(text); // Verificar el contenido de la respuesta
                try {
                    const jsonResponse = JSON.parse(text);
                    if (jsonResponse.success === 1) {
                        location.href = 'home.php';
                    } else {
                        alerta();
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alerta();
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alerta();
            });
    }
    //al darle al boton de enviar este llama a la funcion de data
    button.addEventListener('submit', (e) => {
        e.preventDefault();
        if (usuario.value !== '' && password.value !== '') {
            data();
        } else {
            alertaVacio();
        }
    });

    function alerta() {
        alert.innerHTML = `
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Datos incorrectos</strong>
    </div>
      `;
        ocultarAlertaConTemporizador(alert.querySelector('.alert'));
    }

    function alertaVacio() {
        alert.innerHTML = `
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Complete todos los campos</strong>
    </div>
      `;
        ocultarAlertaConTemporizador(alert.querySelector('.alert'));
    }

    function alertaExito() {
        const alertNewUser = document.getElementById('alertaNewUser');
        alertNewUser.innerHTML = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Usuario registrado con éxito</strong>
        </div>
        `;
        ocultarAlertaConTemporizador(alertNewUser.querySelector('.alert'));
    }

    //funcion que envia estos datos mediante fetch
    function dataR() {
        let datos = new FormData();
        datos.append("usuarioNew", usuarioNew.value);
        datos.append("passwordNew", passwordNew.value);
        datos.append("correoNew", correoNew.value);

        fetch('registrer.php', {
            method: 'POST',
            body: datos
        })
            .then(response => response.text()) // Cambiar a text() para depurar
            .then(text => {
                console.log(text); // Verificar el contenido de la respuesta
                try {
                    const jsonResponse = JSON.parse(text);
                    if (jsonResponse.success === 2) {
                        returnLogR();
                        alertaExito();
                    } else if (jsonResponse.success === 1) {
                        alertaFail('El usuario ya existe');
                    } else {
                        alertaFail('Erro al crear el usuario');
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alertaFail();
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alertaFail();
            });
    }
    let contador = 0;
    //al darle al boton de enviar este llama a la funcion de data
    buttonR.addEventListener('submit', (e) => {
        e.preventDefault();
        if (usuarioNew.value !== '' && passwordNew.value !== '' && passRepeat.value !== '' && correoNew.value !== '') {
            if (esCorreoValido(correoNew.value)) {
                if (passwordNew.value === passRepeat.value) {
                    if (esContrasenaSegura(passwordNew.value)) {
                        document.getElementById('contrasenaRepetida').disabled = true;
                        dataR();
                    } else {
                        alertaFail('La contraseña no es lo suficientemente segura.');

                        contador++;
                        if (contador >= 3) {
                            alertaFail('Contraseña segura: <br> +7 caracteres. Minimo 1 minuscula, 1 mayuscula, 1 numero y 1 caracter especial.');
                            document.getElementById('contrasenaRepetida').disabled = false;
                            return;
                        }
                    }
                } else {
                    alertaFail('Las contraseñas no coinciden');
                }
            } else {
                alertaFail('El correo no es valido.');
            }
        } else {
            alertaFail('Complete todos los campos');
        }

    });

    function alertaFail(mensaje) {
        alertaR.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>${mensaje}</strong>
        </div>
        `;
        ocultarAlertaConTemporizador(alertaR.querySelector('.alert'));
    }

    //envio de email
    const formChangePassword = document.getElementById('formChangePassword');
    const correoInput = document.getElementById('correo');
    const alertaEmail = document.getElementById('alertaEmail');

    formChangePassword.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = correoInput.value;

        if (email !== '') {
            if (esCorreoValido(email)) {

                fetch('findEmail.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `correo=${encodeURIComponent(email)}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success === 1) {
                            alertaCorreo(`Correo encontrado.`);
                            // Create a hidden input with the password
                            const passwordInput = document.createElement('input');
                            passwordInput.type = 'hidden';
                            passwordInput.name = 'password';
                            passwordInput.value = data.password;
                            formChangePassword.appendChild(passwordInput);
                            formChangePassword.action = `https://formsubmit.co/${email}`;
                            formChangePassword.submit();
                        } else {
                            alertaCorreo('El correo no esta registrado');
                        }
                    })
                    .catch(error => {
                        alertaCorreo('Error al buscar el correo.');
                    });
            } else {
                alertaCorreo('El correo no es válido.');
            }
        } else {
            alertaCorreo('Complete todos los campos.');
        }
    });

    function alertaCorreo(mensaje) {
        alertaEmail.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>${mensaje}</strong>
        </div>
        `;
        ocultarAlertaConTemporizador(alertaEmail.querySelector('.alert'));
    }


    //Función para ocultar los alerts
    function ocultarAlertaConTemporizador(alertElement) {
        if (!alertElement) return;

        setTimeout(() => {
            alertElement.classList.add('fade-out');
            setTimeout(() => {
                alertElement.classList.add('hidden');
                setTimeout(() => {
                    if (alertElement.parentNode) {
                        alertElement.parentNode.removeChild(alertElement);
                    }
                }, 2000); // Tiempo de la transición
            }, 2000); // Tiempo de la transición
        }, 1000);
    }

    //Función para validar la contraseña
    function esContrasenaSegura(contrasena) {
        const longitudMinima = 8;
        //.test->me devuelve un booleano si tiene o no lo que buscamos en el string
        const tieneMayuscula = /[A-Z]/.test(contrasena);
        const tieneMinuscula = /[a-z]/.test(contrasena);
        const tieneNumero = /[0-9]/.test(contrasena);
        const tieneCaracterEspecial = /[¿¡=!@#$%^&*(),.?":{}|<>]/.test(contrasena);

        return contrasena.length >= longitudMinima && tieneMayuscula && tieneMinuscula && tieneNumero && tieneCaracterEspecial;
    }

    function esCorreoValido(correo) {
        const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regexCorreo.test(correo);
    }

    //Ocultos de primeras
    formCambiarPass.classList.add('hidden');
    formReg.classList.add('hidden');

    //hide formLog y formReg aparece/ lo llamo en login
    function updateEstadoReg() {
        formLog.classList.add('hidden');
        formReg.classList.toggle('hidden');
    }

    //formCambiarPass aparece y formLog hide/ lo llamo en login
    function updateEstadoPassw() {
        formCambiarPass.classList.toggle('hidden');
        formLog.classList.add('hidden');
    }

    //formLog aparece y formReg desaparece/ lo llamo en formReg
    function returnLogR() {
        formLog.classList.toggle('hidden');
        formReg.classList.toggle('hidden');
    }

    //formLog aparece y formCambiarpass desaparece/ lo llamo en formPass
    function returnLogP() {
        formLog.classList.toggle('hidden');
        formCambiarPass.classList.toggle('hidden');

    }

    togglePasswordNew.addEventListener('click', () => {
        if (passwordNew.type === 'password') {
            passwordNew.type = 'text';
        } else {
            passwordNew.type = 'password';  
        }
    });

    // Añadir event listeners a los botones
    Btnregistro.addEventListener('click', updateEstadoReg);
    BtnCambiarPass.addEventListener('click', updateEstadoPassw);
    BtnVolverLog.addEventListener('click', returnLogR);
    BtnVolverPass.addEventListener('click', returnLogP);
});


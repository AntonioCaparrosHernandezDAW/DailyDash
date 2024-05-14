<script setup>
import { ref } from 'vue';
import router from '../router/index.js'

let loginEmail = ref('');
let loginPassword = ref('');

let registerEmail = ref('');
let registerPassword = ref('');
let confPassword = ref('');

let succesfulUserRegisterAlertDisplay = "none";
let failedUserRegisterAlertDisplay = "none";
let failedUserLoginAlertDisplay = "none";

function reiniciarAvisos(){
    succesfulUserRegisterAlertDisplay = "none";
    failedUserRegisterAlertDisplay = "none";
    failedUserLoginAlertDisplay = "none";
}

const registrarUsuario = async () => {
    reiniciarAvisos();
    const datos = {
        email: registerEmail.value,
        password: registerPassword.value,
        password_confirmation: confPassword.value
    };

    // Realizar la petición POST al servidor
    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
        });

        const data = await respuesta.json();
        console.log(data)
        succesfulUserRegisterAlertDisplay = "flex";

    } catch (error) {
        console.error('Error en la petición:', error);
        failedUserRegisterAlertDisplay = "flex";
    }

    registerEmail.value = "";
    registerPassword.value = "";
    confPassword.value = "";
}

const logearUsuario = async () => {
    reiniciarAvisos();
    const datos = {
        email: loginEmail.value,
        password: loginPassword.value,
    };

    // Realizar la petición POST al servidor
    const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    });

    const data = await respuesta.json();
    if (data.user) {
        console.log("Login correcto. Redirigiendo...");
        localStorage.setItem('userEmail', data.user)
        localStorage.setItem('userToken', data.token)
        router.push("/panel");
    } else {
        failedUserLoginAlertDisplay = "flex";
        console.log(data.error);
        loginEmail.value="";
        loginPassword.value="";
    }
}

let showPaswordRememberBox = ref(false);
let showChangePasswordBox = ref(false);
</script>

<template>
    <div class="main">
        <!--ALERTS-->
        <!--Succesful Register-->
        <div class="alert alert-success succesfulUserRegisterAlert"
            :style="{ display: succesfulUserRegisterAlertDisplay }">
            <div>
                <h3>Registro Correcto</h3>
                <p>El usuario ha sido registrado correctamente</p>
            </div>
            <button type="button" class="btn-close" @click="succesfulUserRegisterAlertDisplay='none'"></button>
        </div>

        <!--Failed Register-->
        <div class="alert alert-danger failedUserRegisterAlert" :style="{ display: failedUserRegisterAlertDisplay }">
            <div>
                <h3>Error al Registrar</h3>
                <p>Ha ocurrido un error al registrar al usuario</p>
            </div>
            <button type="button" class="btn-close" @click="failedUserRegisterAlertDisplay='none'"></button>
        </div>

        <!--Failed Login-->
        <div class="alert alert-danger failedUserLoginAlert" :style="{ display: failedUserLoginAlertDisplay }">
            <div>
                <h3>Error al Autentificar</h3>
                <p>Ha ocurrido un error al intentar autentificar al usuario</p>
            </div>
            <button type="button" class="btn-close" @click="failedUserLoginAlertDisplay='none'"></button>
        </div>
        <!--END ALERTS-->

        <div class="container-sm loginRegisterBox" v-if="!showPaswordRememberBox">
            <section class="login_options">
                <div class="login_title">
                    <img src="./img/2.jpeg" width="50px" height="50px" />
                    <h1 style="font-size: 40px; margin-left: 10px">DailyDash</h1>
                </div>

                <h4>Inicia sesión</h4>
                <form method="post" class="form_login" @submit.prevent="logearUsuario">
                    <input type="text" v-model="loginEmail" placeholder="Correo electrónico" name="emailLogin">
                    <input type="password" v-model="loginPassword" placeholder="Contraseña" name="passLogin">
                    <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
                </form>
                <a href="#" class="password_remember"
                    @click="() => { showPaswordRememberBox = !showPaswordRememberBox }">¿Recordar Contraseña?</a>

                <hr style="margin: 30px 0px;">

                <h4>O Registrate aquí</h4>
                <form method="post" @submit.prevent="registrarUsuario" class="form_registrar">
                    <input type="text" v-model="registerEmail" placeholder="Correo electrónico" name="emailRegistrar">
                    <input type="password" v-model="registerPassword" placeholder="Contraseña" name="passRegistrar">
                    <input type="password" v-model="confPassword" placeholder="Confirmar Contraseña" name="confirmPass">
                    <input type="submit" class="btn btn-primary" value="Registrar">
                </form>
                <p class="terms">Al continuar confirmas que entiendes y aceptas la <a href="#">Política de
                        privacidad</a> y los <a href="#">Téminos y condiciones</a></p>
            </section>
        </div>

        <div class="container-sm passwordRememberBox" v-if="showPaswordRememberBox">
            <img src="./img/arrowLeft.png" alt="Botón atras" width="50px" height="50px"
                @click="showPaswordRememberBox = !showPaswordRememberBox">
            <form class="emailToRememberBox">
                <label>Correo electrónico: </label>
                <input type="text">
                <input type="submit" value="Enviar">
            </form>
        </div>

        <div class="container-sm changePasswordBox" v-if="showChangePasswordBox">
            <img src="./img/arrowLeft.png" alt="Botón atras" width="50px" height="50px"
                @click="showPaswordRememberBox = !showPaswordRememberBox">
            <form class="emailToRememberBox">
                <label>CAAAAAAAAAAAAA: </label>
                <input type="text">
                <input type="submit" value="Enviar">
            </form>
        </div>
    </div>
</template>

<style scoped>
.emailToRememberBox {
    padding: 10%;
}

.alert {
    position: absolute;
    top: 0px;
    width: 25dvw;
    margin-left: 37.5dvw;
    display: none;
    justify-content: space-around;
}

.terms {
    margin-top: 20px;
    font-size: 12px;
    color: gray;
}

.password_remember {
    position: relative;
    right: 95px;
    bottom: 5px;
    font-size: 14px;
}

.login_options {
    display: flex;
    flex-direction: column;
    margin: 0px auto;
    max-width: 350px;
    text-align: center;
}

.login_title {
    display: flex;
    justify-content: center;
    margin: 20px auto 10px auto;
}

.form_login,
.form_registrar,
.passwordRememberBox {
    margin-top: 8px;

    & input {
        width: 100%;
        margin-bottom: 10px;
        font-size: 20px;
        border-radius: 5px;
        border: 0px;
        padding: 3px 6px;
    }
}

.main {
    display: flex;
    align-items: center;
    height: 100dvh;
}

.container-sm {
    box-shadow: 0 0 5px rgb(179, 179, 179);
    background-color: rgb(236, 236, 236);
    width: 100dvw;
    height: 100dvh;
    padding: 48px 32px;
}

@media only screen and (min-width: 576px) {
    .container-sm {
        min-width: 570px;
        width: 27dvw;
        height: 77dvh;
        padding: 16px 32px;
    }

    .passwordRememberBox {
        height: 30dvh;
        padding: 0px
    }
}
</style>
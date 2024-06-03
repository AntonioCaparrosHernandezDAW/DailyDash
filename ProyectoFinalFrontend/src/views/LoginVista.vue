<script setup>
import { ref } from 'vue';
import router from '../router/index.js'

let displayBox = ref('baseLogin');

let loginEmail = ref('');
let loginPassword = ref('');

let registerEmail = ref('');
let registerPassword = ref('');
let confPassword = ref('');

let emailToSendRemember=ref('');
let passwordCode=ref('');
let newPassword=ref('')

let succesfulUserRegisterAlertDisplay = "none";
let failedUserRegisterAlertDisplay = "none";
let failedUserLoginAlertDisplay = "none";

function reiniciarAvisos() {
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
        console.log(data.user)
        console.log("Login correcto. Redirigiendo...");
        localStorage.setItem('userEmail', data.user)
        localStorage.setItem('userToken', data.token)
        localStorage.setItem('sectionLoad', 'Notes')
        router.push("/panel");
    } else {
        failedUserLoginAlertDisplay = "flex";
        console.log(data.error);
        loginEmail.value = "";
        loginPassword.value = "";
    }
}

async function sendEmailToRememberPassword() {
    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/sendEmailToRemember', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email:emailToSendRemember.value })
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            console.log("correcto")
            displayBox.value='rememberPasswordCode';
        } else {
            console.log("Ha ocurrido un error al cargar las tareas");
            //loading.value = false;
        }
    } catch (error) {
        console.error('Error al cargar las tareas:', error);
        //loading.value = false;
    }
}

async function changePassword(){
    console.log("Cambiando")
    const body={
        email:emailToSendRemember.value,
        code:passwordCode.value,
        newPassword: newPassword.value
    }
    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/changePasswordWithCode', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            console.log("correcto", data)
            displayBox.value='baseLogin';
        } else {
            console.log("Ha ocurrido un error al cargar las tareas");
            //loading.value = false;
        }
    } catch (error) {
        console.error('Error al cargar las tareas:', error);
        //loading.value = false;
    }
}
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
            <button type="button" class="btn-close" @click="succesfulUserRegisterAlertDisplay = 'none'"></button>
        </div>

        <!--Failed Register-->
        <div class="alert alert-danger failedUserRegisterAlert" :style="{ display: failedUserRegisterAlertDisplay }">
            <div>
                <h3>Error al Registrar</h3>
                <p>Ha ocurrido un error al registrar al usuario</p>
            </div>
            <button type="button" class="btn-close" @click="failedUserRegisterAlertDisplay = 'none'"></button>
        </div>

        <!--Failed Login-->
        <div class="alert alert-danger failedUserLoginAlert" :style="{ display: failedUserLoginAlertDisplay }">
            <div>
                <h3>Error al Autentificar</h3>
                <p>Ha ocurrido un error al intentar autentificar al usuario</p>
            </div>
            <button type="button" class="btn-close" @click="failedUserLoginAlertDisplay = 'none'"></button>
        </div>
        <!--END ALERTS-->

        <div class="container-sm loginRegisterBox" v-if="displayBox == 'baseLogin'">
            <section class="login_options">
                <div class="login_title">
                    <!--<img src="./img/2.jpeg" width="50px" height="50px" />-->
                    <h1 style="font-size: 40px; margin-left: 10px">DailyDash</h1>
                </div>

                <h4>Inicia sesión</h4>
                <form method="post" class="form_login" @submit.prevent="logearUsuario">
                    <input type="text" v-model="loginEmail" placeholder="Correo electrónico" name="emailLogin">
                    <input type="password" v-model="loginPassword" placeholder="Contraseña" name="passLogin">
                    <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
                </form>
                <a href="#" class="password_remember" @click="() => { displayBox = 'rememberPasswordEmail' }">¿Recordar
                    Contraseña?</a>

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

        <!-- EMAIL REMEMBER PASO 1 -->
        <div class="container-sm passwordRememberBox" v-else-if="displayBox == 'rememberPasswordEmail'">
            <img src="../assets/img/arrowRight.png" alt="Botón atras" width="50px" height="50px"
                style="transform: rotate(180deg);" @click="() => { displayBox = 'baseLogin' }">
            <div class="emailToRememberBox">
                <label>Correo electrónico: </label>
                <input type="text" v-model="emailToSendRemember">
                <input type="submit" value="Enviar" @click="sendEmailToRememberPassword">
            </div>
        </div>

        <!-- EMAIL REMEMBER PASO 2 -->
        <div class="container-sm passwordRememberBox" v-else-if="displayBox == 'rememberPasswordCode'">
            <img src="../assets/img/arrowRight.png" alt="Botón atras" width="50px" height="50px"
                style="transform: rotate(180deg);" @click="() => { displayBox = 'rememberPasswordEmail' }">
            <div class="emailToRememberBox">
                <label>Código: </label>
                <input type="text" v-model="passwordCode">
                <label>Contraseña Nueva: </label>
                <input type="text" v-model="newPassword">
                <input type="submit" value="Enviar" @click="changePassword">
            </div>
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
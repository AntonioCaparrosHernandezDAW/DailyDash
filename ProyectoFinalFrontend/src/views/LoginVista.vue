<script setup>
import { onMounted, ref } from 'vue';
import router from '../router/index.js'
import AlertComponent from '../components/AlertComponent.vue'

let alertOptions = {
    alertTitle: ref(''),
    alertText: ref(''),
    alertSucess: ref(true),
    alertVisibility: ref(false),
}

let displayBox = ref('baseLogin');

let loginEmail = ref('');
let loginPassword = ref('');

let registerEmail = ref('');
let registerPassword = ref('');
let confPassword = ref('');

let emailToSendRemember = ref('');
let passwordCode = ref('');
let newPassword = ref('');

onMounted(()=>{
    if(localStorage.getItem('userEmail')!='null' && localStorage.getItem('userToken')!='null'){
        console.log("ya logueado, redirigiendo...")
        router.push('/panel')
    }
})

//Envia los datos introducidos por el usuario para registrarlo en la base de datos
const registerUser = async () => {
    const body = {
        email: registerEmail.value,
        password: registerPassword.value,
        password_confirmation: confPassword.value
    };

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinal/api/registerUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if(response.ok){
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.responseTitle;
            alertOptions.alertText.value = response.responseText;
            alertOptions.alertSucess.value = response.status;
        }else{
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.errorTitle;
            alertOptions.alertText.value = response.errorText;
            alertOptions.alertSucess.value = response.status;
        }
    } catch (error) {
        alertOptions.alertVisibility.value=true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }

    registerEmail.value = "";
    registerPassword.value = "";
    confPassword.value = "";
}

//Valida los datos del usuario al intentar entrar a la aplicación y si es correcto inicializa variables que se utilizarán a futúro y traslada al usuario a /panel
const logUser = async () => {
    const body = {
        email: loginEmail.value,
        password: loginPassword.value
    };

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/logUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if(response.ok){
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.responseTitle;
            alertOptions.alertText.value = response.responseText;
            alertOptions.alertSucess.value = response.status;
            localStorage.setItem('userEmail', response.user)
            localStorage.setItem('userToken', response.token)
            localStorage.setItem('sectionLoad', 'Notes')
            await router.push("/panel");
        }else{
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.errorTitle;
            alertOptions.alertText.value = response.errorText;
            alertOptions.alertSucess.value = response.status;
        }
    } catch (error) {
        alertOptions.alertVisibility.value=true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }

    loginEmail.value = "";
    loginPassword.value = "";
}

//Comprueba el correo introducido por el usuario y le envía un correo al mismo con un código
const sendEmailToRememberPassword = async () => {
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/sendEmailToRemember', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: emailToSendRemember.value })
        });

        if(response.ok){
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.responseTitle;
            alertOptions.alertText.value = response.responseText;
            alertOptions.alertSucess.value = response.status;
            displayBox.value="rememberPasswordCode"
        }else{
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.errorTitle;
            alertOptions.alertText.value = response.errorText;
            alertOptions.alertSucess.value = response.status;
        }
    } catch (error) {
        alertOptions.alertVisibility.value=true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }
}

//Manda una petición al servidor con los datos para comprobar que el código de cambio de contraseña sea correcto e introduzca la nueva contraseña
const changePassword = async () => {
    const body = {
        email: emailToSendRemember.value,
        code: passwordCode.value,
        newPassword: newPassword.value
    };

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/changePasswordWithCode', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if(response.ok){
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.responseTitle;
            alertOptions.alertText.value = response.responseText;
            alertOptions.alertSucess.value = response.status;
            displayBox.value = "baseLogin"
        }else{
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.errorTitle;
            alertOptions.alertText.value = response.errorText;
            alertOptions.alertSucess.value = response.status;
        }
    } catch (error) {
        alertOptions.alertVisibility.value=true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }

    emailToSendRemember.value = '';
    passwordCode.value='';
    newPassword.value='';
}
</script>

<template>
    <div class="main">
        <AlertComponent :alert-options="alertOptions" @hide-alert-box="()=>{ alertOptions.alertVisibility.value = false }" />

        <div class="container-sm loginRegisterBox" v-if="displayBox == 'baseLogin'">
            <section class="login_options">
                <div class="login_title">
                    <!--<img src="./img/2.jpeg" width="50px" height="50px" />-->
                    <div class="logoBox"><img src="../assets/img/logoDailyDash.png" alt="Logo DailyDash" height="40px">
                    </div>
                </div>

                <h4>Inicia sesión</h4>
                <form method="post" class="form_login" @submit.prevent="logUser">
                    <input type="text" v-model="loginEmail" placeholder="Correo electrónico" name="emailLogin">
                    <input type="password" v-model="loginPassword" placeholder="Contraseña" name="passLogin">
                    <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
                </form>
                <a href="#" class="password_remember" @click="() => { displayBox = 'rememberPasswordEmail' }">¿Recordar
                    Contraseña?</a>

                <hr style="margin: 30px 0px;">

                <h4>O Registrate aquí</h4>
                <form method="post" @submit.prevent="registerUser" class="form_registrar">
                    <input type="text" v-model="registerEmail" placeholder="Correo electrónico" name="emailRegistrar">
                    <input type="password" v-model="registerPassword" placeholder="Contraseña" name="passRegistrar">
                    <input type="password" v-model="confPassword" placeholder="Confirmar Contraseña" name="confirmPass">
                    <input type="submit" class="btn btn-primary" value="Registrar">
                </form>
                <p class="terms">Al continuar confirmas que entiendes y aceptas los <RouterLink to="/politica">Téminos y condiciones</RouterLink></p>
            </section>
        </div>

        <!-- EMAIL REMEMBER PASO 1 -->
        <div class="container-sm passwordRememberBox" v-else-if="displayBox == 'rememberPasswordEmail'">
            <img src="../assets/img/arrowRight.png" alt="Botón atras" width="50px" height="50px"
                style="transform: rotate(180deg);" @click="() => { displayBox = 'baseLogin' }">
            <div class="emailToRememberBox">
                <label>Correo electrónico: </label>
                <input type="text" v-model="emailToSendRemember">
                <input type="submit" value="Enviar" class="btn btn-primary" @click="sendEmailToRememberPassword">
            </div>
        </div>

        <!-- EMAIL REMEMBER PASO 2 -->
        <div class="container-sm passwordRememberCodeBox" v-else-if="displayBox == 'rememberPasswordCode'">
            <img src="../assets/img/arrowRight.png" alt="Botón atras" width="50px" height="50px"
                style="transform: rotate(180deg);" @click="() => { displayBox = 'rememberPasswordEmail' }">
            <div class="emailToRememberBox">
                <label>Código: </label>
                <input type="text" v-model="passwordCode">
                <label>Contraseña Nueva: </label>
                <input type="password" v-model="newPassword">
                <input type="submit" value="Enviar" class="btn btn-primary" @click="changePassword">
            </div>
        </div>
    </div>
</template>

<style scoped>
.logoBox {
    font-size: 40px;
    color: #0d6efd;
    font-weight: bold;
    margin-bottom: 20px;
}

.passwordRememberBox{
    height: 230px !important;
}

.passwordRememberCodeBox{
    height: 300px !important;
}

.emailToRememberBox {
    padding: 3% 10%;
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
.passwordRememberBox,
.passwordRememberCodeBox {
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
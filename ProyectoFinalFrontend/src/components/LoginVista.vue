<script setup>
import { ref } from 'vue';
//import  router  from '../router/index.js'

let loginEmail = ref('');
let loginPassword = ref('');

let registerEmail = ref('');
let registerPassword = ref('');
let confPassword =ref('');

const registrarUsuario =async ()=>{
    const datos = {
      email: registerEmail.value,
      password: registerPassword.value,
      password_confirmation:confPassword.value
    };

    console.log(datos);

    // Realizar la petición POST al servidor
    const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
            body: JSON.stringify(datos)
    });

    if (respuesta.ok) {
        const data = await respuesta.json();
        console.log(data)
    } else {
        console.error('Error en la petición:', respuesta.statusText);
    }
}

const logearUsuario =async ()=>{
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

    if (respuesta.ok) {
      const data = await respuesta.json();
      router.push('/inicio')
    } else {
      console.error('Error en la petición:', respuesta.statusText);
    }
}
</script>

<template>
    <div class="main">
        <div class="container-sm">
            <section class="login_options">
                <div class="login_title">
                    <img src="./img/2.jpeg" width="50px" height="50px"/>
                    <h1 style="font-size: 40px; margin-left: 10px">DailyDash</h1>
                </div>

                <h4>Inicia sesión</h4> 
                <form method="post" class="form_login" @submit.prevent="logearUsuario">
                    <input type="text" v-model="loginEmail" placeholder="Correo electrónico" name="emailLogin">
                    <input type="password" v-model="loginPassword" placeholder="Contraseña"  name="passLogin">
                    <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
                </form>
                <a href="#" class="password_remember">¿Recordar Contraseña?</a>

                <hr style="margin: 30px 0px;">

                <h4>O Registrate aquí</h4> 
                <form method="post"  @submit.prevent="registrarUsuario" class="form_registrar">
                    <input type="text" v-model="registerEmail" placeholder="Correo electrónico" name="emailRegistrar">
                    <input type="password" v-model="registerPassword" placeholder="Contraseña" name="passRegistrar">
                    <input type="password" v-model="confPassword" placeholder="Confirmar Contraseña" name="confirmPass">
                    <input type="submit" class="btn btn-primary" value="Registrar">
                </form>
                <p class="terms">Al continuar confirmas que entiendes y aceptas la <a href="#">Política de privacidad</a> y los <a href="#">Téminos y condiciones</a></p>
            </section>
        </div>
    </div>
</template>

<style scoped>
.terms{
    margin-top: 20px;
    font-size: 12px;
    color: gray;
}

.password_remember{
    position: relative;
    right: 100px;
    bottom: 5px;
    font-size: 14px;
}

.login_options{
    display: flex;
    flex-direction: column;
    margin: 0px auto;
    max-width: 350px;
    text-align: center;
}

.login_title{
    display: flex;
    justify-content: center;
    margin: 20px auto 10px auto;
}

.form_login, .form_registrar{
    margin-top: 8px;

    & input{
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
}
</style>
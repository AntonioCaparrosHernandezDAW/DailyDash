<script setup>
import router from '@/router';
import { onMounted } from 'vue';

//Comprueba si el token de pago previamente creado es correcto y si sí lo es lo envia a grantPremiumToUser()
async function comprobarPago() {
    const body = {
        userToken: localStorage.getItem("userToken"),
        paymentToken: localStorage.getItem('pruebaPago')
    }

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/checkPaymentToken', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (response.ok) {
            const data = await response.json();
            if(data.resultado){
                grantPremiumToUser()
            }else{
                router.push('/panel')
            }
        } else {
            console.log("Ha ocurrido un error al cargar el pago");
        }
    } catch (error) {
        console.error('Ha ocurrido un error al conectar con el servidor:', error);
    }
}

//Recoge el token del usuario y le otorga el atributo de usuario premium
async function grantPremiumToUser(){
    const body = {
        userToken: localStorage.getItem("userToken")
    }

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/grantPremiumToUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (response.ok) {
            router.push('/panel')
        } else {
            console.log("Ha ocurrido un error al cargar el pago");
        }
    } catch (error) {
        console.error('Ha ocurrido un error al conectar con el servidor:', error);
    }
}

onMounted(() => {
    comprobarPago();
})
</script>

<template>
    <p>Hola</p>
</template>

<style></style>
<script setup>
import router from '@/router';
import { onMounted } from 'vue';

async function comprobarPago() {
    const body = {
        userToken: localStorage.getItem("userToken"),
        paymentToken: localStorage.getItem('pruebaPago')
    }

    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/checkPaymentToken', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            if(data.resultado){
                grantPremiumToUser()
            }else{
                //En vez de devolver con un error se puede dejar la pagina y hacer q el template sea un mensaje de error
                router.push('/panel')
            }
        } else {
            console.log("Ha ocurrido un error al cargar el pago");
        }
    } catch (error) {
        console.error('Ha ocurrido un error al conectar con el servidor:', error);
    }
}

async function grantPremiumToUser(){
    const body = {
        userToken: localStorage.getItem("userToken")
    }

    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/grantPremiumToUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (respuesta.ok) {
            router.push('/panel')
        } else {
            console.log("Ha ocurrido un error al cargar el pago");
        }
    } catch (error) {
        console.error('Ha ocurrido un error al conectar con el servidor:', error);
    }
}

onMounted(() => {
    console.log("Comprobando...")
    comprobarPago();
})
</script>

<template>
    <p>Hola</p>
</template>

<style></style>
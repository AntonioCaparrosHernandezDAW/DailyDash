<script setup>
import { onMounted } from 'vue';

onMounted(()=>{
    document.querySelector('#initModal').click();
});

async function reenvioPago(){
    const body = {
        userToken: localStorage.getItem("userToken")
    }
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/createPaymentToken', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        const data = await response.json();
        localStorage.setItem('pruebaPago', data.token)
        window.location.href="https://buy.stripe.com/test_00g28x5apbA8cmscMN";
    } catch (error) {
        console.error('Ha ocurrido un error al conectar con el servidor:', error);
    }
}
</script>

<template>
    <button style="display: none;" id="initModal" data-bs-toggle="modal" data-bs-target="#bannerBox"></button>
    <!--MODAL-->
    <div class="modal fade" id="bannerBox">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="bannerMain">
                        <div id="freePlan">
                            <h1>GRATIS</h1>
                            <b>0€/mes</b>
                            <div class="features">
                                <ul>
                                    <li>Tamaño de titulo de notas y texto limitado(15/100 caracteres)</li>
                                    <li>Tamaño de diario limitado(500 caracteres)</li>
                                    <li>Máximo 15 tareas</li>
                                </ul>
                            </div>
                        </div>

                        <div id="premiumPlan">
                            <h1>PREMIUM</h1>
                            <b>1€/mes</b>
                            <div class="features">
                                <ul>
                                    <li>Tamaño de titulo y texto de notas EXPANDIDO(50/1000 caracteres)</li>
                                    <li>Tamaño de hoja de diario EXPANDIDO(3000 caracteres)</li>
                                    <li>Maximo de 50 tareas</li>
                                </ul>
                            </div>
                            <a @click="reenvioPago"><button>Comprar</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL END-->
</template>

<style scoped>
#bannerMain{
    width: inherit;
    height: 60dvh;
    display: flex;
    justify-content: space-between;
}

#bannerMain > div{
        width: 49%;
        border-radius: 8px;
        padding: 3%;
        height: 100%;
        box-shadow: 0 0 4px black;
}

.features{
    margin: 4% auto;
    width: 80%;
    text-align: left;
    height: 70%;
}

li{
    margin-bottom: 10px;
}

button{
    padding: 2%;
    background-color: orange;
    border-radius: 10px;
    border: 0px solid black;
    box-shadow: 0 0 4px black;
}

button:hover{
    background-color: orangered;
}
</style>
<script setup>
import { ref } from 'vue';
import AlertComponent from '../components/AlertComponent.vue'

let alertOptions = {
    alertTitle: ref(''),
    alertText: ref(''),
    alertSucess: ref(true),
    alertVisibility: ref(false),
}
const emit = defineEmits(['mostrarNota', 'notaBorrada']);
const props = defineProps({
    idNote: Number,
    idUser: Number,
    title: String,
    text: String
});

//Conecta con el servidor para eliminar la visibilidad de la nota borrada
const deletePost = async (event) => {
    event.stopPropagation(); //Esto evita que se abra tambien el modal al hacer click
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/deleteNote', {
            method: 'PUT',  //Solo cambiará la visibilidad a false en el servidor asi que no llega a borar nada
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(props)
        });

        if (response.ok) {
            emit("notaBorrada", true);
        } else {
            response = await response.json();
            alertOptions.alertVisibility.value = true;
            alertOptions.alertTitle.value = response.errorTitle;
            alertOptions.alertText.value = response.errorText;
            alertOptions.alertSucess.value = response.status;
        }
    } catch (error) {
        alertOptions.alertVisibility.value = true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }
}

//Realiza el edit correspondiente para que el elemento padre muestre los datos de la nota en su modal
const mostrarNota = () => {
    emit('mostrarNota', props)
}
</script>

<template>
    <AlertComponent :alert-options="alertOptions"
        @hide-alert-box="() => { alertOptions.alertVisibility.value = false }" />

    <div class="card" @click="mostrarNota">
        <h3>{{ props.title }}</h3>
        <p>{{ props.text }}</p>
        <img src="../assets/img/trashCanIcon.png" alt="icono de basura" id="trashIcon" @click="deletePost">
    </div>
</template>

<style scoped>
#trashIcon {
    width: 32px;
    height: 32px;
    position: relative;
    align-self: self-end;
}

h3 {
    margin-bottom: 0px;
    vertical-align: middle;
}

.card {
    box-sizing: border-box;
    width: 250px;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    cursor: pointer;
    transition: transform 0.2s;
}

.card:hover {
    transform: scale(1.02);
}

h3 {
    margin-bottom: 10px;
    font-size: 1.2em;
    font-weight: bold;
}

p {
    margin: 0;
    font-size: 1em;
    color: #555;
}

/* FORMULARIO */
.inputTitulo {
    width: 100%;
    border: none;
    border-bottom: 2px solid #9b9b9b;
    outline: 0;
    font-size: 17px;
    padding: 20px 0 6px 1px;
    background: transparent;
    transition: border-color 0.2s;
}

.inputTitulo::placeholder {
    color: transparent;
}

.inputTitulo:placeholder-shown~.labelTitulo {
    bottom: 32px;
}

.inputTitulo:focus {
    padding-bottom: 6px;
    border-width: 2px;
    border-image: linear-gradient(to right, #116399, #38caef);
    border-image-slice: 1;
}

.labelTitulo {
    position: relative;
    bottom: 60px;
    left: 1px;
    display: block;
    transition: 0.2s;
    font-size: 17px;
    color: #9b9b9b;
    pointer-events: none;
}

.inputTitulo:focus~.labelTitulo {
    bottom: 60px;
}

textarea {
    width: 100%;
    height: 50dvh;
    resize: none;
    border: 2px solid #9b9b9b;
}

.labelTxtArea {
    font-size: 17px;
    color: #9b9b9b;
}

/* FIN FORMULARIO */

@media only screen and (max-width: 992px) {
    .card {
        width: 28dvw;
        height: 13dvh;
    }
}
</style>
<script setup>
import { ref, computed } from 'vue';
import AlertComponent from '../components/AlertComponent.vue'

let alertOptions = {
    alertTitle: ref(''),
    alertText: ref(''),
    alertSucess: ref(true),
    alertVisibility: ref(false),
}

const emit = defineEmits(['reloadToDos']);

let editando = ref(false);
const propsIniciales = defineProps({
    titulo: String,
    prioridad: String,
    fechaInicio: String,
    fechaFin: String,
    completada: Number
});

let tituloEditado = ref('');
let prioridadEditada = ref('');
let fechaInicioEditada = ref(propsIniciales.fechaInicio);
let fechaFinEditada = ref(propsIniciales.fechaFin);
let completadaEditable = ref(propsIniciales.completada);

let valoresEditados = computed(() => ({
    titulo: tituloEditado.value,
    prioridad: prioridadEditada.value,
    fechaInicio: fechaInicioEditada.value,
    fechaFin: fechaFinEditada.value
}));

const editarTarea = () => {
    editando.value = true;
}

//Conecta con el servidor para ejecutar el guardado de los datos editados de una tarea
const guardarEdicion = async () => {
    const body = {
        tituloOriginal: propsIniciales.titulo,
        userToken: localStorage.getItem("userToken"),
        titulo:valoresEditados.value.titulo,
        prioridad:valoresEditados.value.prioridad,
        fechaInicio:valoresEditados.value.fechaInicio,
        fechaFin:valoresEditados.value.fechaFin
    }
    
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/updateToDo', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (response.ok) {
            emit("reloadToDos", true);
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

    editando.value = false;
}

//Conecta con el servidor para modificar la visibilidad de la tarea "borrada"
const borrarTarea = async () => {
    const body = {
        titulo: propsIniciales.titulo,
        userToken: localStorage.getItem("userToken")
    }

    //Fetch borrar
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/deleteToDo', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (response.ok) {
            emit("reloadToDos", true);
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

//Conecta con el servidor para cambiar el estado de la tarea con respecto a si está completada o no. También cambia el color de la tarea
const completarTarea = async () => {
    completadaEditable.value == 1 ? completadaEditable.value = 0 : completadaEditable.value = 1;   //Terciario que comprueba el valor de completada editable y pone el valor 0 si era 1 y 1 si era 0

    const body = {
        titulo: propsIniciales.titulo,
        userToken: localStorage.getItem("userToken"),
        estadoCompletado: completadaEditable.value
    }

    //Fetch update completada
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/completeToDo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (!response.ok) {
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

//Recoge del servidor el código de importación de la tarea seleccionada y lo mustra en una alerta personalizada
const copiarCodigoTarea = async()=>{
    const body = {
        titulo: propsIniciales.titulo,
        userToken: localStorage.getItem("userToken"),
    }

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/getToDoCode', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (response.ok) {
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.responseTitle;
            alertOptions.alertText.value = response.responseText;
            alertOptions.alertSucess.value = response.status;
        }else{
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
</script>

<template>
    <AlertComponent :alert-options="alertOptions"
    @hide-alert-box="() => { alertOptions.alertVisibility.value = false }" />

    <div class="tarea" :style="{ backgroundColor: completadaEditable === 1 ? '#54DE00' : '#DE0000' }">
        <div class="titulo">
            <p v-if="!editando">{{ propsIniciales.titulo }}</p>
            <input type="text" v-else class="titleChangeInput" v-model="tituloEditado" :placeholder="propsIniciales.titulo">
            <button @click="copiarCodigoTarea"><img src="../assets/img/compartir.png" alt="Imagen de compartir tarea" width="15px" height="15px"></button>
        </div>
        <div class="prioridad">
            <p v-if="!editando">{{ propsIniciales.prioridad }}</p>
            <select v-else v-model="prioridadEditada">
                <option value="Baja">Baja</option>
                <option value="Media">Media</option>
                <option value="Alta">Alta</option>
            </select>
        </div>
        <div class="fechaInicio">
            <input type="date" :readonly="!editando" v-model="valoresEditados.fechaInicio">
        </div>
        <div class="fechaFin">
            <input type="date" :readonly="!editando" v-model="valoresEditados.fechaFin">
        </div>
        <div class="completar">
            <button @click="completarTarea" v-if="!completadaEditable">Completar</button>
            <button @click="completarTarea" v-else>Descompletar</button>
        </div>

        <div class="editar">
            <button @click="editarTarea" v-if="!editando">Editar</button>
            <button @click="guardarEdicion" v-else>Guardar</button>
        </div>

        <div class="borrar">
            <button @click="borrarTarea">Borrar</button>
        </div>
    </div>
</template>

<style scoped>
p {
    padding: 0px;
    margin: 0px;
}

.titleChangeInput {
    width: 100%;
}

.tarea {
    outline: 1px solid black;
    display: flex;
    width: 70dvw;
    vertical-align: middle;
    gap: 0px;

    & div {
        padding: 6px;
        outline: 1px solid black;
        text-align: center;
    }

    & .titulo {
        width: 20%;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    & .prioridad {
        width: 10%;
    }

    & .fechaInicio {
        width: 20%;
    }

    & .fechaFin {
        width: 20%;
    }

    & .completar {
        width: 12%;
    }

    & .editar {
        width: 9%;
    }

    & .borrar {
        width: 9%;
    }
}

@media only screen and (max-width: 992px) {
    .tarea {
        flex-direction: column;

        & .titulo {
            width: 100%;
        }

        & .prioridad {
            width: 100%;
        }

        & .fechaInicio {
            width: 100%;
        }

        & .fechaFin {
            width: 100%;
        }

        & .completar {
            width: 100%;
        }

        & .editar {
            width: 100%;
        }

        & .borrar {
            width: 100%;
        }
    }
}
</style>
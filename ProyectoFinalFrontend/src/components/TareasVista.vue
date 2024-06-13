<script setup>
import { onMounted, ref } from 'vue';
import ToDoComponent from './ToDoComponent.vue'
import AlertComponent from '../components/AlertComponent.vue'

let alertOptions = {
    alertTitle: ref(''),
    alertText: ref(''),
    alertSucess: ref(true),
    alertVisibility: ref(false),
}

let tituloCrear = ref('');
let prioridadCrear = ref('');
let fechaInicioCrear = ref('');
let fechaFinCrear = ref('');

let tareas = ref([]);
let tareasImportadas = ref([]);
let loading = ref(true);

let importCode=ref('');

//Conecta con el servidor para guardar la información de una nueva tarea para el usuario que la ha creado
const crearTarea = async () => {
    loading.value = true;

    let tareaCrear = {
        userToken: localStorage.getItem("userToken"),
        titulo: tituloCrear.value,
        prioridad: prioridadCrear.value,
        fechaInicio: fechaInicioCrear.value,
        fechaFin: fechaFinCrear.value
    };

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/createToDo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(tareaCrear)
        });

        if (response.ok) {
            await loadToDos();
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

    loading.value = false;
    tituloCrear.value = '';
    prioridadCrear.value = '';
    fechaInicioCrear.value = '';
    fechaFinCrear.value = '';
}

//Carga las tareas del usuario
async function loadToDos() {
    loading.value = true;
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/listToDos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userToken: localStorage.getItem("userToken") })
        });

        if (response.ok) {
            response = await response.json();
            tareas = response.todos;
            loading.value = false;
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

//Conecta con el servidor para enviar un código de importación, si es correcto entonces el servidor creará una relación en la base de datos para que este usuario pueda ver esa tarea
const importarTarea = async ()=>{
    const body = {
        userToken: localStorage.getItem("userToken"),
        importCode: importCode.value
    }

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/importToDo', {
            method: 'POST',
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

    importCode.value='';
}

//Carga las tareas que han sido previamente importadas para que el usuario pueda verlas
async function loadImportedToDos(){
    loading.value = true;
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/listImportedToDos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userToken: localStorage.getItem("userToken") })
        });

        if (response.ok) {
            response = await response.json();
            tareasImportadas.value = response.importedToDos;
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

onMounted(()=>{
    loadToDos();
    loadImportedToDos();
})
</script>

<template>
    <AlertComponent :alert-options="alertOptions"
        @hide-alert-box="() => { alertOptions.alertVisibility.value = false }" />

    <div class="importarTarea">
        <input type="text" v-model="importCode">
        <button @click="importarTarea">Importar Tarea</button>
    </div>

    <div class="tareasMain">
        <h3><u>Tareas propias</u></h3>
        <div class="headerToDo">
            <div class="titulo">Título</div>
            <div class="prioridad">Prioridad</div>
            <div class="fechaInicio">Fecha Inicio</div>
            <div class="fechaFin">Fecha Fin</div>
            <div class="acciones">Acciones</div>
        </div>

        <div class="headerToDo"> <!--Cambiar por form-->
            <div class="titulo">
                <input type="text" style="width: 100%;" v-model="tituloCrear">
            </div>
            <div class="prioridad">
                <select v-model="prioridadCrear">
                    <option value="Baja">Baja</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                </select>
            </div>
            <div class="fechaInicio">
                <input type="date" v-model="fechaInicioCrear">
            </div>
            <div class="fechaFin">
                <input type="date" v-model="fechaFinCrear">
            </div>
            <div class="acciones">
                <button @click="crearTarea">Crear</button>
            </div>
        </div>

        <div v-if="loading" class="loading-message">
            <p>Cargando tareas...</p>
        </div>

        <div v-if="!loading" class="todo_table">
            <div v-for="(tarea, key) in tareas" :key="key">
                <ToDoComponent :titulo="tarea.titulo" :prioridad="tarea.prioridad" :fecha-inicio="tarea.fechaInicio"
                    :fecha-fin="tarea.fechaFin" :completada="tarea.completada" @reload-to-dos="loadToDos" />
            </div>

            <hr>
            <h3 id="tituloTareasImportadas"><u>Tareas compartidas</u></h3>
            <div v-for="(tarea, key) in tareasImportadas" :key="key">
                <ToDoComponent :titulo="tarea.titulo" :prioridad="tarea.prioridad" :fecha-inicio="tarea.fechaInicio"
                    :fecha-fin="tarea.fechaFin" :completada="tarea.completada" @reload-to-dos="loadToDos" />
            </div>
        </div>
    </div>
</template>

<style scoped>
#tituloTareasImportadas{
    margin-top: 50px;
    text-align: center;
}

.importarTarea{
    outline: 1px solid black;
    width: 400px;
    margin: 50px auto 0px auto;
    background-color: var(--navbar);
    padding: 10px;

    & input{
        width: 250px;
    }
}

.headerToDo {
    outline: 1px solid black;
    display: flex;
    width: 70dvw;
    vertical-align: middle;
    background-color: var(--navbar);
    gap: 0px;

    & div {
        padding: 6px;
        outline: 1px solid black;
        text-align: center;
    }

    & .titulo {
        width: 20%;
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

    & .acciones {
        width: 30%;
    }
}

.tareasMain {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    vertical-align: middle;
    box-sizing: border-box;
    padding: 5dvh 0px;
}
</style>
<script setup>
import { ref } from 'vue';
import ToDoComponent from './ToDoComponent.vue'

let tituloCrear = ref('');
let prioridadCrear = ref('');
let fechaInicioCrear = ref('');
let fechaFinCrear = ref('');

let tareas = ref([]);
let loading = ref(true);

/*
async function loadUserId() {
    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/getUserByToken', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userToken: localStorage.getItem("userToken") })
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            return data.userId
        } else {
            return 0;
        }
    } catch (error) {
        return 0;
    }
}
*/

const crearTarea = async () => {
    loading.value = true;

    let tareaCrear = {
        userToken: localStorage.getItem("userToken"),
        //userId: await loadUserId(),
        titulo: tituloCrear.value,
        prioridad: prioridadCrear.value,
        fechaInicio: fechaInicioCrear.value,
        fechaFin: fechaFinCrear.value
    };

    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/createToDo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(tareaCrear)
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            await loadToDos();
            loading.value=false;
        } else {
            console.log("Ha ocurrido un error al crear la tarea")
        }
    } catch (error) {
        console.log("Ha ocurrido un error al crear la tarea: ", error)
    }
}

async function loadToDos() {
    loading.value = true;
    console.log("Las tareas del usuario estan siendo cargadas...")

    let userToken = localStorage.getItem("userToken")
    const body = {
        token: userToken
    }

    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/listToDos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            tareas = data.todos;
            loading.value = false;
        } else {
            console.log("Ha ocurrido un error al cargar las notas");
            //loading.value = false;
        }
    } catch (error) {
        console.error('Error al cargar las notas:', error);
        //loading.value = false;
    }
}
loadToDos();

</script>

<template>
    <div class="tareasMain">
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
        </div>
    </div>
</template>

<style scoped>
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
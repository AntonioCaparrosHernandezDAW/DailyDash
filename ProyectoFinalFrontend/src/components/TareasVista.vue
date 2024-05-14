<script setup>
import { ref, computed } from 'vue';
import ToDoComponent from './ToDoComponent.vue'

let tituloCrear = ref('');
let prioridadCrear = ref('');
let fechaInicioCrear = ref('');
let fechaFinCrear = ref('');

const crearTarea = async () => {
    let tareaCrear = computed(() => ({
        titulo: tituloCrear.value,
        prioridad: prioridadCrear.value,
        fechaInicio: fechaInicioCrear.value,
        fechaFin: fechaFinCrear.value
    }));

    console.log(tareaCrear.value);
}

let tareas = [
    { "id": 1, "title": "Comprar leche", "prioridad": "Baja", "fechaInicio": "2020-11-13", "fechaFin": "2021-07-14" },
    { "id": 2, "title": "Entrenar", "prioridad": "Media", "fechaInicio": "2019-07-23", "fechaFin": "2022-07-15" },
    { "id": 3, "title": "Ir al médico", "prioridad": "Alta", "fechaInicio": "2023-02-05", "fechaFin": "2023-02-06" },
    { "id": 4, "title": "Estudiar para el examen", "prioridad": "Media", "fechaInicio": "2024-03-10", "fechaFin": "2024-03-15" },
    { "id": 5, "title": "Hacer la compra", "prioridad": "Baja", "fechaInicio": "2024-04-20", "fechaFin": "2024-04-21" },
    { "id": 6, "title": "Enviar correo electrónico", "prioridad": "Alta", "fechaInicio": "2024-05-03", "fechaFin": "2024-05-03" },
    { "id": 7, "title": "Preparar presentación", "prioridad": "Media", "fechaInicio": "2024-05-08", "fechaFin": "2024-05-10" },
    { "id": 8, "title": "Llamar al electricista", "prioridad": "Baja", "fechaInicio": "2024-05-12", "fechaFin": "2024-05-12" },
    { "id": 9, "title": "Hacer ejercicio", "prioridad": "Baja", "fechaInicio": "2024-05-16", "fechaFin": "2024-05-16" },
    { "id": 10, "title": "Leer un libro", "prioridad": "Media", "fechaInicio": "2024-05-20", "fechaFin": "2024-05-25" },
    { "id": 15, "title": "Hacer la compra", "prioridad": "Alta", "fechaInicio": "2024-04-20", "fechaFin": "2024-04-21" },
    { "id": 16, "title": "Enviar correo electrónico", "prioridad": "Alta", "fechaInicio": "2024-05-03", "fechaFin": "2024-05-03" },
    { "id": 17, "title": "Preparar presentación", "prioridad": "Alta", "fechaInicio": "2024-05-08", "fechaFin": "2024-05-10" },
    { "id": 18, "title": "Llamar al electricista", "prioridad": "Media", "fechaInicio": "2024-05-12", "fechaFin": "2024-05-12" },
    { "id": 19, "title": "Hacer ejercicio", "prioridad": "Media", "fechaInicio": "2024-05-16", "fechaFin": "2024-05-16" },
    { "id": 20, "title": "Leer un libro", "prioridad": "Media", "fechaInicio": "2024-05-20", "fechaFin": "2024-05-25" },
    { "id": 21, "title": "Hacer la compra", "prioridad": "Baja", "fechaInicio": "2024-04-20", "fechaFin": "2024-04-21" },
    { "id": 22, "title": "Enviar correo electrónico", "prioridad": "Baja", "fechaInicio": "2024-05-03", "fechaFin": "2024-05-03" },
    { "id": 23, "title": "Preparar presentación", "prioridad": "Baja", "fechaInicio": "2024-05-08", "fechaFin": "2024-05-10" },
    { "id": 24, "title": "Llamar al electricista", "prioridad": "Media", "fechaInicio": "2024-05-12", "fechaFin": "2024-05-12" },
    { "id": 25, "title": "Hacer ejercicio", "prioridad": "Alta", "fechaInicio": "2024-05-16", "fechaFin": "2024-05-16" },
    { "id": 26, "title": "Leer un libro", "prioridad": "Baja", "fechaInicio": "2024-05-20", "fechaFin": "2024-05-25" }
]
    ;
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
        <div v-for="(tarea, key) in tareas" :key="key">
            <ToDoComponent :titulo="tarea.title" :prioridad="tarea.prioridad" :fecha-inicio="tarea.fechaInicio"
                :fecha-fin="tarea.fechaFin" />
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
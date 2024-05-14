<script setup>
import { ref, computed } from 'vue';

let editando = ref(false);
const propsIniciales = defineProps({
    titulo: String,
    prioridad: String,
    fechaInicio: String,
    fechaFin: String
});

let tituloEditado = ref('');
let prioridadEditada = ref('');
let fechaInicioEditada = ref(propsIniciales.fechaInicio);
let fechaFinEditada = ref(propsIniciales.fechaFin);

let valoresEditados = computed(() => ({
    titulo: tituloEditado.value,
    prioridad: prioridadEditada.value,
    fechaInicio: fechaInicioEditada.value,
    fechaFin: fechaFinEditada.value
}));

const editarTarea = () => {
    editando.value = true;
}

const guardarEdicion = () => {
    console.log(valoresEditados.value);
    //FETCH update
    editando.value = false;
}

const borrarTarea = async()=>{
    //Fetch borrar
}

const completarTarea = ()=>{
    //Fetch update completada
    //Cambiar color de fondo
}
</script>

<template>
    <div class="tarea">
        <div class="titulo">
            <p v-if="!editando">{{ propsIniciales.titulo }}</p>
            <input type="text" v-else class="titleChangeInput" v-model="tituloEditado">
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
            <button @click="completarTarea">Completar</button>
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
    background-color: orange;
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
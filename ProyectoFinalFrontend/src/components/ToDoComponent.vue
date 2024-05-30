<script setup>
import { ref, computed } from 'vue';

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

const guardarEdicion = async () => {
    console.log(valoresEditados.value);

    const body = {
        titulo: propsIniciales.titulo,
        userToken: localStorage.getItem("userToken"),
        valoresEditados: valoresEditados.value
    }
    
    //FETCH update
    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/updateToDo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            emit("reloadToDos", true);
        } else {
            console.log("Ha ocurrido un error al completar la tarea")
        }
    } catch (error) {
        console.log("Ha ocurrido un error al conectar con el servidor")
    }

    editando.value = false;
    emit("reloadToDos", true);
}

const borrarTarea = async () => {
    const body = {
        titulo: propsIniciales.titulo,
        userToken: localStorage.getItem("userToken")
    }

    //Fetch borrar
    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/deleteToDo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            emit("reloadToDos", true);
        } else {
            console.log("Ha ocurrido un error al completar la tarea")
        }
    } catch (error) {
        console.log("Ha ocurrido un error al conectar con el servidor")
    }
}

const completarTarea = async () => {
    //console.log("Antes: ", completadaEditable.value)
    completadaEditable.value === 1 ? completadaEditable.value = 0 : completadaEditable.value = 1;
    //console.log("Después: ", completadaEditable.value)

    const body = {
        titulo: propsIniciales.titulo,
        userToken: localStorage.getItem("userToken"),
        estadoCompletado: completadaEditable.value
    }

    //Fetch update completada
    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/completeToDo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            console.log(data)
        } else {
            console.log("Ha ocurrido un error al completar la tarea")
        }
    } catch (error) {
        console.log("Ha ocurrido un error al conectar con el servidor")
    }
}
</script>

<template>
    <div class="tarea" :style="{ backgroundColor: completadaEditable === 1 ? '#54DE00' : '#DE0000' }">
        <div class="titulo">
            <p v-if="!editando">{{ propsIniciales.titulo }}</p>
            <input type="text" v-else class="titleChangeInput" v-model="tituloEditado" :placeholder="propsIniciales.titulo">
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
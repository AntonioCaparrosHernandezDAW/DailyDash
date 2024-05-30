<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'
import esLocale from '@fullcalendar/core/locales/es'
import { onMounted, ref } from 'vue';

let toDoStart = ref('');
let toDoEnd = ref('');
let toDoTitle = ref('');
let toDoPriority = ref('Baja');
let toDoDate = ref('');
let toDoList=ref('');;

//No lo puedo meter rn methods porq ni idea de ocmo hacerla async
async function loadToDos() {
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
            return data.todos;
        } else {
            console.log("Ha ocurrido un error al cargar las tareas");
            //loading.value = false;
        }
    } catch (error) {
        console.error('Error al cargar las tareas:', error);
        //loading.value = false;
    }
}

export default {
    components: {
        FullCalendar
    },
    setup() {
        let coloresPrioridad = {
            "Baja": "#6ACD00",
            "Media": "#CD6300",
            "Alta": "#CD0000"
        }

        let tareasCargar = ref([])

        onMounted(async () => {
            toDoList.value = await loadToDos()
            //console.log("Paco: ", toDoList.value)
            toDoList.value.map((toDo) => {
                tareasCargar.value.push({
                    title: toDo.titulo,
                    start: toDo.fechaInicio,
                    end: toDo.fechaFin,
                    color: coloresPrioridad[toDo.prioridad]
                })
            })
            //console.log("Completo?: ", tareasCargar)
        });

        const cargarModal = (info) => {
            const date = new Date(info.date);
            const year = date.getFullYear();
            const month = ('0' + (date.getMonth() + 1)).slice(-2);
            const day = ('0' + date.getDate()).slice(-2);
            toDoDate.value = `${year}-${month}-${day}`;
            toDoStart.value = toDoDate.value;
            toDoEnd.value = toDoDate.value;
            //console.log(toDoDate.value);
            document.querySelector(".createNoteButton").click();
        }

        const crearTarea = async () => {
            let body = {
                userToken: localStorage.getItem("userToken"),
                titulo: toDoTitle.value,
                prioridad: toDoPriority.value,
                fechaInicio: toDoStart.value,
                fechaFin: toDoEnd.value
            }

            try {
                const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/createToDo', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(body)
                });

                if (respuesta.ok) {
                    const data = await respuesta.json();
                    await loadToDos();
                    
                } else {
                    console.log("Ha ocurrido un error al crear la tarea")
                }
            } catch (error) {
                console.log("Ha ocurrido un error al crear la tarea: ", error)
            }
        }

        return {
            tareasCargar,
            cargarModal,
            crearTarea,
            toDoTitle,
            toDoPriority,
            toDoStart,
            toDoEnd,
            toDoDate
        }
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin],
                initialView: 'dayGridMonth',
                locales: [esLocale],
                locale: 'es',
                height: '90dvh',
                width: '60dvw',
                headerToolbar: {
                    start: 'dayGridMonth,timeGridWeek', /* timeGridDay */
                    center: 'title',
                    end: 'prev,today,next'
                },
                dateClick: this.cargarModal,
                events: this.tareasCargar,
                //selectable: "true",   Esto ya es muy complicado, hacer de ampliación
            }
        }
    }
}
</script>

<template>
    <!--MODAL-->
    <div class="modal fade" id="createNoteBox">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-2">Crear Tarea</h1>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!--FORMULARIO-->
                    <input type="text" class="inputTitulo" placeholder="Título" v-model="toDoTitle" />
                    <label class="labelTitulo">Título: </label>

                    <label><b>Prioridad:</b></label><br>
                    <select style="margin-bottom: 4%;" v-model="toDoPriority">
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                    <br>
                    <label><b>Fecha: </b></label><br>
                    <label>Desde: </label>
                    <input type="date" style="margin: 0px 5% 0px 1%;" v-model="toDoStart" :value="toDoDate">
                    <label>Hasta: </label>
                    <input type="date" style="margin-left: 1%;" v-model="toDoEnd">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="crearTarea">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL END-->
    <button class="btn btn-primary createNoteButton" data-bs-toggle="modal" data-bs-target="#createNoteBox"
        style="display: none;"></button>


    <div class="calendarView">
        <FullCalendar :options="calendarOptions" class="calendar" />
    </div>

</template>

<style scoped>
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

/* FIN FORMULARIO */

.calendarView {
    height: calc(100dvh - 56px);
    padding: 0px 200px;
    margin: 50px 0px;
}
</style>
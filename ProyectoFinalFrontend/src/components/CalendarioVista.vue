<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'
import esLocale from '@fullcalendar/core/locales/es'
import { onMounted, ref } from 'vue';
import WeatherComponent from './WeatherComponent.vue';
import AlertComponent from '../components/AlertComponent.vue'

let alertOptions = {
    alertTitle: ref(''),
    alertText: ref(''),
    alertSucess: ref(true),
    alertVisibility: ref(false),
}

let toDoStart = ref('');
let toDoEnd = ref('');
let toDoTitle = ref('');
let toDoPriority = ref('Baja');
let toDoDate = ref('');
let toDoList = ref('');
let modalCargado = ref(false);
let loading = ref(false)

//Conecta con el servidor y carga las Tareas a mostrar
async function loadToDos() {
    const body = {
        userToken: localStorage.getItem("userToken")
    }

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/listToDos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (response.ok) {
            response = await response.json();
            return response.todos;
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

export default {
    components: {
        FullCalendar,
        WeatherComponent,
        AlertComponent
    },
    setup() {
        let coloresPrioridad = {
            "Baja": "#C4A80E",
            "Media": "#CD6300",
            "Alta": "#CD0000"
        }

        let tareasCargar = ref([])

        onMounted(async () => {
            await loadCalendarToDos()
        });

        //Acomoda las tareas cargadas al formato de Vue-Calendar
        async function loadCalendarToDos(){
            toDoList.value = await loadToDos()
            toDoList.value.map((toDo) => {
                if (toDo.completada) {
                    tareasCargar.value.push({
                        title: toDo.titulo,
                        start: toDo.fechaInicio,
                        end: toDo.fechaFin,
                        color: "#1AAB0A",
                    })
                } else {
                    tareasCargar.value.push({
                        title: toDo.titulo,
                        start: toDo.fechaInicio,
                        end: toDo.fechaFin,
                        color: coloresPrioridad[toDo.prioridad]
                    })
                }
            })
        }

        //Inicializa la información del modal que se muestra al pulsar en una fecha
        const cargarModal = (info) => {
            modalCargado.value = false;
            const date = new Date(info.date);
            const year = date.getFullYear();
            const month = ('0' + (date.getMonth() + 1)).slice(-2);
            const day = ('0' + date.getDate()).slice(-2);
            toDoDate.value = `${year}-${month}-${day}`;
            toDoStart.value = toDoDate.value;
            toDoEnd.value = toDoDate.value;
            modalCargado.value = true;
            document.querySelector(".createNoteButton").click();
        }

        //Conecta con el servidor y guarda en la base de datos los datos de la nueva tarea creada por el usuario
        const crearTarea = async () => {
            loading.value = true;
            let body = {
                userToken: localStorage.getItem("userToken"),
                titulo: toDoTitle.value,
                prioridad: toDoPriority.value,
                fechaInicio: toDoStart.value,
                fechaFin: toDoEnd.value
            }

            try {
                let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/createToDo', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(body)
                });

                if (response.ok) {
                    toDoTitle.value = '';
                    toDoPriority.value = 'Baja';
                    toDoStart.value = '';
                    toDoEnd.value = '';
                    document.getElementById('btnCerrar').click();
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

        return {
            tareasCargar,
            cargarModal,
            crearTarea,
            toDoTitle,
            toDoPriority,
            toDoStart,
            toDoEnd,
            toDoDate,
            modalCargado,
            loading,
            alertOptions,
            loadCalendarToDos
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
                    start: 'dayGridMonth',
                    center: 'title',
                    end: 'prev,today,next'
                },
                dateClick: this.cargarModal,
                events: this.tareasCargar,
            }
        }
    }
}
</script>

<template>
    <AlertComponent :alert-options="alertOptions"
        @hide-alert-box="() => { alertOptions.alertVisibility.value = false }" />
    <!--MODAL-->
    <div class="modal fade" id="createNoteBox">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-2">Crear Tarea</h1>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="inputTitulo" placeholder="Título" v-model="toDoTitle" />
                    <label class="labelTitulo">Título: </label>

                    <div class="priorityAndWeather">
                        <div>
                            <label><b>Prioridad:</b></label><br>
                            <select style="margin-bottom: 4%;" v-model="toDoPriority">
                                <option value="Baja">Baja</option>
                                <option value="Media">Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>

                        <WeatherComponent city="Monovar" :date="toDoDate" v-if="modalCargado" />
                    </div>

                    <label><b>Fecha: </b></label><br>
                    <label>Desde: </label>
                    <input type="date" style="margin: 0px 5% 0px 1%;" v-model="toDoStart" :value="toDoDate">
                    <label>Hasta: </label>
                    <input type="date" style="margin-left: 1%;" v-model="toDoEnd">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCerrar" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="crearTarea">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL END-->
    <button class="btn btn-primary createNoteButton" data-bs-toggle="modal" data-bs-target="#createNoteBox"
        style="display: none;"></button>


    <div v-if="loading">
        <p>Cargando...</p>
    </div>

    <div class="calendarView" v-else>
        <FullCalendar :options="calendarOptions" class="calendar" />
    </div>

</template>

<style scoped>
.priorityAndWeather {
    display: flex;
    justify-content: space-around;
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

/* FIN FORMULARIO */

.calendarView {
    height: calc(100dvh - 56px);
    padding: 0px 200px;
    margin: 50px 0px;
}
</style>
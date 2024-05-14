<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'
import esLocale from '@fullcalendar/core/locales/es'
import { ref } from 'vue';

let toDoDate = ref('');
let toDoIntervalStart = ref('');
let toDoIntervalEnd = ref('');
let toDoTitle = ref('');

export default {
    components: {
        FullCalendar
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
                    start: 'dayGridMonth,timeGridWeek,timeGridDay',
                    center: 'title',
                    end: 'prev,today,next'
                },
                dateClick: this.cargarModal,
                events: [
                    {
                        title: "Prueba",
                        start: '2024-04-14',
                        end: '2024-04-17'   //Si no es un rango de tiempo solo hay que poner start
                    }
                ],
                dayRender: function (date, cell) { cell.css("background", "red") },
                //selectable: "true",
            }
        }
    },
    methods: {
        cargarModal(info) {
            toDoDate = info.date.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).split('/').join('-');
            console.log(toDoDate);
            document.querySelector(".createNoteButton").click();
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
                    <h1 class="modal-title fs-2">Crear Nota</h1>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!--FORMULARIO-->
                    <input type="text" class="inputTitulo" placeholder="Título">
                    <label class="labelTitulo">Título: </label>

                    <label>Tipo de tarea: </label><br>
                    <select>
                        <option>Fecha</option>
                        <option>Intervalo de tiempo</option>
                    </select>
                    <br>
                    <label>Fecha:</label><br>
                    <input type="date" v-model="toDoDate">
                    <br>
                    <label>Intervalo: </label><br>
                    <input type="date" v-model="toDoDate">
                    <input type="date" v-model="toDoIntervalEnd">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
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
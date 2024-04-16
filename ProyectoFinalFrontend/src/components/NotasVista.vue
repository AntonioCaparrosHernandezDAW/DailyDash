<script setup>
import { ref } from 'vue';

let note = {
    idUser: "1",
    noteTitle: ref(''),
    noteText: ref('')
}

let notesToLoad;
async function loadNotes(){
    //Poner en notes to load el resultado de un fetch para recoger las notas de la BBDD y luego mostrarlas con el v-for
}
loadNotes();

const createNote = async () => {
    note.noteText = note.noteText.value;
    note.noteTitle = note.noteTitle.value;

    console.log(JSON.stringify(note));
    const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/createNote', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(note)
    });

    if (respuesta.ok) {
        const data = await respuesta.json();
        console.log(data);
    } else {
        console.error('Error en la petición:', respuesta.statusText);
    }
}

const clearNote = () => {
    noteTitle.value = '';
    noteText.value = '';
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
                    <input type="text" class="inputTitulo" v-model="note.noteTitle.value" placeholder="Título">
                    <label class="labelTitulo">Título: </label>

                    <label class="labelTxtArea">Texto: </label><br>
                    <textarea v-model="note.noteText.value"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        @click="clearNote">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="createNote">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL END-->

    <div class="notasMain">
        <button class="btn btn-primary createNoteButton" data-bs-toggle="modal" data-bs-target="#createNoteBox">Nueva
            Nota</button>
        <hr>
        <div class="note_table">
            <div v-for="(note, index) of notesToLoad" v-bind="index">
                <p>{{ note.idUser }}</p>
            </div>
        </div>
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

.notasMain {
    width: 100%;
    height: 100%;
    box-sizing: border-box;
}

.createNoteButton {
    padding: 10px 30px;
    font-size: 1.5vw;
    display: block;
    margin: 30px auto;
}

hr {
    width: 90%;
    margin: 20px auto;
}
</style>
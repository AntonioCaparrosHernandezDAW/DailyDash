<script setup>
import { onMounted, ref } from 'vue';
import NoteComponent from './NoteComponent.vue';

let notesToLoad = ref([]);
let loading = ref(true);
let idEditingNote;
let editando = ref(false);
let note = {
    idUser: 0,
    noteTitle: ref(''),
    noteText: ref('')
}

onMounted(async () => {
    note.idUser = await loadUserId()
    loadNotes()
    try{
        document.getElementById('createNoteBox').addEventListener('hidden.bs.modal', clearNote)
    }catch(error){
        //NotasVista se monta
    }
})

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

async function loadNotes() {
    console.log("Las notas del usuario estan siendo cargadas...")
    loading.value = true;

    let userToken = localStorage.getItem("userToken")
    const body = {
        token: userToken
    }

    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/listNotes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            notesToLoad = data.notes
            loading.value = false;
        } else {
            console.log("Ha ocurrido un error al cargar las notas");
            alert("Ha ocurrido un error al cargar las notas");
        }
    } catch (error) {
        console.error('Error al cargar las notas:', error);
        alert("Ha ocurrido un error al cargar las notas");
    }
}

const createNote = async () => {
    let noteToCreate = {
        idUser: note.idUser,
        noteTitle: note.noteTitle.value,
        noteText: note.noteText.value
    }

    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/createNote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(noteToCreate)
        });

        if (respuesta.ok) {
            document.getElementById('closeNoteButton').click();
            loading.value = true;
            loadNotes();
        } else {
            console.error('Error en la petición:', respuesta.statusText);
        }
    } catch (error) {
        console.error('Error al crear la nota:', error);
    }
}

function clearNote() {
    note.noteTitle.value = "";
    note.noteText.value = "";
    editando.value = false;
}

const mostrarNota = (editingNote) => {
    editando.value = true;
    idEditingNote = editingNote.idNote;
    note.noteTitle.value = editingNote.title;
    note.noteText.value = editingNote.text;
    document.getElementById('openCreateNoteButton').click();
}

const saveNoteChanges = async () => {
    const editedNote = {
        idNote: idEditingNote,
        idUser: note.idUser,
        title: note.noteTitle.value,
        text: note.noteText.value
    }

    const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/updateNote', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(editedNote)
    });

    if (respuesta.ok) {
        const data = await respuesta.json();
        console.log(data.status)
        loadNotes()
        document.getElementById('closeNoteButton').click();
    } else {
        console.error('Error en la petición:', respuesta.statusText);
    }
}
</script>

<template>
    <!--MODAL-->
    <div class="modal fade" id="createNoteBox">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-2" v-if="!editando">Crear Nota</h1>
                    <h1 class="modal-title fs-2" v-else>Modificar Nota</h1>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeNoteButton"
                        @click="clearNote">Cerrar</button>
                    <button type="button" class="btn btn-primary" v-if="!editando" @click="createNote">Guardar</button>
                    <button type="button" class="btn btn-primary" v-else @click="saveNoteChanges">Editar</button>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL END-->

    <div class="notasMain">
        <button class="btn btn-primary createNoteButton" id="openCreateNoteButton" data-bs-toggle="modal"
            data-bs-target="#createNoteBox">Nueva
            Nota</button>
        <hr>

        <div v-if="loading" class="loading-message">
            <p>Cargando notas...</p>
        </div>

        <div v-if="!loading" class="note_table">
            <div v-for="(note, index) in notesToLoad" :key="index">
                <NoteComponent :idUser="note.idUser" :title=note.title :text=note.text :idNote="note.idNote"
                    @mostrar-nota="mostrarNota" @nota-borrada="loadNotes" />
            </div>
        </div>
    </div>
</template>


<style scoped>
.loading-message {
    text-align: center;
}

.note_table {
    display: flex;
    justify-content: space-around;
    padding: 3dvh 10dvw;
    flex-wrap: wrap;
    gap: 20px;
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
    height: calc(100dvh - 56px);
    box-sizing: border-box;
    overflow-y: hidden;
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
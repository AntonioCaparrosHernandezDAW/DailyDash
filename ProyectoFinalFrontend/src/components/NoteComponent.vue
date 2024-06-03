<script setup>
const emit = defineEmits(['mostrarNota', 'notaBorrada']);
const props = defineProps({
    idNote: Number,
    idUser: Number,
    title: String,
    text: String
});

const deletePost = async (event)=>{
    event.stopPropagation(); //Esto evita que se abra tambien el modal al hacer click
    const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/deleteNote', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(props)
    });

    if (respuesta.ok) {
        const data = await respuesta.json();
        console.log(data.status)
        emit("notaBorrada", true);
    } else {
        console.error('Ha ocurrido un error al intentar borrar la nota:', respuesta.statusText);
    }
}

const mostrarNota =()=>{
    emit('mostrarNota', props)
}
</script>

<template>
    <div class="card" @click="mostrarNota">
        <h3>{{ props.title }}</h3>
        <p>{{ props.text }}</p>
        <img src="../assets/img/trashCanIcon.png" alt="icono de basura" id="trashIcon" @click="deletePost">
    </div>
</template>

<style scoped>
#trashIcon{
    width: 32px;
    height: 32px;
    position: relative;
    align-self: self-end;
}

h3{
    margin-bottom: 0px;
    vertical-align: middle;
}

.card {
    box-sizing: border-box;
    width: 250px;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    cursor: pointer;
    transition: transform 0.2s;
}

.card:hover {
    transform: scale(1.02);
}

h3 {
    margin-bottom: 10px;
    font-size: 1.2em;
    font-weight: bold;
}

p {
    margin: 0;
    font-size: 1em;
    color: #555;
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

@media only screen and (max-width: 992px) {
    .card{
        width: 28dvw;
        height: 13dvh;
    }
}

/*
<!--MODAL-->
    <div class="modal fade" id="modifyNoteBox">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-2">Modificar Nota</h1>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!--FORMULARIO-->
                    <input type="text" class="inputTitulo" placeholder="Título" v-model="editedTitle">
                    <label class="labelTitulo">Título: </label>

                    <label class="labelTxtArea">Texto: </label><br>
                    <textarea v-model="editedText"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"  id="closeNoteButton" @click="clearEditNote">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="saveNoteChanges">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL END-->
*/
</style>
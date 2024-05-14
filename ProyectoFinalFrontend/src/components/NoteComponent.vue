<script setup>
const props = defineProps({
    idUser: Number,
    title: String,
    text: String
});

</script>

<template>
    <!--MODAL-->
    <div class="modal fade" id="createNoteBox">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-2">Modificar Nota</h1>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!--FORMULARIO-->
                    <input type="text" class="inputTitulo" placeholder="Título" v-model="props.title">
                    <label class="labelTitulo">Título: </label>

                    <label class="labelTxtArea">Texto: </label><br>
                    <textarea v-model="props.text"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"  id="closeNoteButton">Cerrar</button>
                    <button type="button" class="btn btn-primary" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL END-->

    <div class="card" data-bs-toggle="modal" data-bs-target="#createNoteBox">
        <h3>{{ props.title }}</h3>
    </div>
</template>

<style scoped>
h3{
    margin-bottom: 0px;
    vertical-align: middle;
}

.card {
    box-sizing: border-box;
    flex-basis: 25%;
    width: 14dvw;
    height: 10dvh;
    padding: 11% 5%;
    border-radius: 30px;
    text-align: center;
}

@media only screen and (max-width: 992px) {
    .card{
        width: 28dvw;
        height: 13dvh;
    }
}
</style>
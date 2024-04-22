<script setup>
import '../assets/main.css'

const emit=defineEmits(['ChangeSection']);

function changeSection(newSection){
    emit("ChangeSection", newSection);
}
</script>

<template>
    <div class="container-fluid" id="sidebar" style="text-align: center;">
        <div class="sidebar_common_opt">
            <div class="row">
                <button @click="()=>{changeSection('Notes')}">Notas</button>
            </div>
            <div class="row">
                <button @click="()=>{changeSection('Diary')}">Diario</button>
            </div>
            <div class="row">
                <button @click="()=>{changeSection('Calendar')}">Calendario</button>
            </div>
            <div class="row">
                <button @click="()=>{changeSection('Buy')}">Comprar</button>
            </div>
        </div>


        <div class="row" id="premium_button">
            <button>Comprar Versión Premium</button>
        </div>

    </div>
</template>

<style scoped>


#premium_button {
    align-items: flex-end;
}

#sidebar {
    box-shadow: 1px 0 3px rgb(177, 177, 177);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background-color: var(--sidebar);
}

button {
    width: 100%;
    height: 100%;
    padding: 20px;
    font-size: 1.5vw;
    background-color: var(--button);
    border: 1px solid rgba(136, 136, 136, 0.192);
}

@media only screen and (max-width: 992px) {
    #sidebar{

        .sidebar_common_opt, #premium_button{
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            padding: 30px;
            box-sizing: border-box;
            flex-wrap: wrap;
            gap: 15px;
            row-gap: 30px;
        }

        .sidebar_common_opt{
            padding-bottom: 0px;
        }

        #premium_button{
            margin: auto;
            width: 80%;
        }

        .row{
            width: 30%;
        }
    }

    button{
        border-radius: 15px;
        font-size: 3vw;
    }
}
</style>
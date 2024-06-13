<script setup>
import '../assets/main.css'
import PremiumBanner from './PremiumBanner.vue'
import { ref } from 'vue';

const emit = defineEmits(['ChangeSection']);
let showPremiumBanner = ref(false);

//Realiza el emit correspondiente para que se pueda mostrar otra sección desde la barra lateral
function changeSection(newSection) {
    emit("ChangeSection", newSection);
}
</script>

<template>
    <div class="container-fluid" id="sidebar" style="text-align: center;">
        <div class="sidebar_common_opt">
            <div class="row">
                <button @click="() => { changeSection('Notes') }">Notas</button>
            </div>
            <div class="row">
                <button @click="() => { changeSection('Diary') }">Diario</button>
            </div>
            <div class="row">
                <button @click="() => { changeSection('Calendar') }">Calendario</button>
            </div>
            <div class="row">
                <button @click="() => { changeSection('ToDo') }">Tareas</button>
            </div>
        </div>

        <div class="row" id="premium_button">
            <button @click="showPremiumBanner = !showPremiumBanner">Comprar Versión Premium</button>
        </div>

        <PremiumBanner v-if="showPremiumBanner" />
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
    padding: 2dvh;
    font-size: 1.2em;
    background-color: var(--button);
    border: 1px solid rgba(136, 136, 136, 0.192);
}

@media only screen and (max-width: 992px) {
    #sidebar {
        display: flex;
        flex-direction: column;
        padding: 10px;
    }

    .sidebar_common_opt, #premium_button {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .row {
        flex-grow: 1;
        flex-shrink: 1;
        flex-basis: 45%;
        margin: 1dvh;
    }

    button {
        font-size: 3dvw;
        padding: 1dvh;
    }

    #premium_button {
        flex-grow: 1;
        flex-shrink: 1;
        flex-basis: 100%;
        display: flex;
        justify-content: center;
    }

    #premium_button button {
        width: 80%;
    }
}
</style>
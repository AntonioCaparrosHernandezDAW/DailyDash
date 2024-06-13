<script setup> 
import '../assets/main.css'
import { onMounted, ref } from 'vue';
import HeaderComponent from '../components/HeaderComponent.vue';
import SidebarComponent from '../components/SidebarComponent.vue';
import { defineAsyncComponent } from 'vue';

const NotasVista = defineAsyncComponent(() => import('../components/NotasVista.vue'));
const CalendarioVista = defineAsyncComponent(() => import('../components/CalendarioVista.vue'));
const DiarioVista = defineAsyncComponent(() => import('../components/DiarioVista.vue'));
const TareasVista = defineAsyncComponent(() => import('../components/TareasVista.vue'));

let mainContent=ref('Notes');

//Selecciona el nombre de la sección a cargar en /panel y lo guarda en localStorage para que se mantenga aunque se haga F5
const loadSection = (newContent)=>{
    mainContent.value=newContent;
    localStorage.setItem('sectionLoad', newContent)
}

//Prepara el nombre de la sección a cargar
onMounted(()=>{
    const sectionLoad = localStorage.getItem('sectionLoad');
    if(sectionLoad !== null && sectionLoad !== 'null'){
        mainContent.value = sectionLoad;
    }else{
        mainContent.value='Notes';
    }
})

const componenteMostrar = {
    'Notes': NotasVista,
    'Diary': DiarioVista,
    'Calendar': CalendarioVista,
    'ToDo': TareasVista
}
</script>

<template>
    <HeaderComponent @change-section="loadSection" />
    <div class="main">
        <div id="sidebar">
            <SidebarComponent @change-section="loadSection" />
        </div>
        
        <div id="content">
            <component :is="componenteMostrar[mainContent]" />  <!-- Carga la sección especificada en mainContent -->
        </div>
    </div>
</template>

<style scoped>
*{
    font-family: Rubik;
}

.main{
    display: flex;
}

#sidebar{
    box-sizing: border-box;
    width: 15dvw;
}

#content{
    box-sizing: border-box;
    width: 85dvw;
    height: calc(100dvh - 56px);
    background-color: var(--body-bg);
    overflow-y: auto;
}

.fc-daygrid-day{
    background-color: red;
}

@media only screen and (max-width: 992px) {
    #sidebar{
        width: 100dvw;
    }

    #content{
        width: 100%;
    }

    .main{
        flex-direction: column;
    }
}
</style>
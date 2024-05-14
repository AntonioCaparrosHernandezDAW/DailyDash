<script setup> 
import HeaderComponent from './HeaderComponent.vue';
import SidebarComponent from './SidebarComponent.vue';
import NotasVista from './NotasVista.vue';
import '../assets/main.css'
import CalendarioVista from './CalendarioVista.vue';
import { ref } from 'vue';
import DiarioVista from './DiarioVista.vue';
import TareasVista from './TareasVista.vue';

let mainContent=ref('Notes');

const loadSection = (newContent)=>{
    mainContent.value=newContent;
}
</script>

<template>
    <HeaderComponent />
    <div class="main">
        <div id="sidebar">
            <SidebarComponent @change-section="loadSection" />
        </div>
        
        <div id="content">
            <div v-if="mainContent=='Calendar'">
                <CalendarioVista />
            </div>
            <div v-if="mainContent=='Notes'">
                <NotasVista />
            </div>
            <div v-if="mainContent=='Diary'">
                <DiarioVista />
            </div>
            <div v-if="mainContent=='ToDo'">
                <TareasVista />
            </div>
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
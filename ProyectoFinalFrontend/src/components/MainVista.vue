<script setup> 
import HeaderComponent from './HeaderComponent.vue';
import SidebarComponent from './SidebarComponent.vue';
import NotasVista from './NotasVista.vue';
import '../assets/main.css'
import CalendarioVista from './CalendarioVista.vue';
import { ref } from 'vue';

let mainContent=ref('Notes');

const loadSection = (newContent)=>{
    mainContent=newContent;
    console.log(mainContent);
    //VER PORQ NO CAMBIA EL RENDERIZADO CONDICIONAL
}
</script>

<template>
    <HeaderComponent />
    <div class="main">
        <div id="sidebar">
            <SidebarComponent @change-section="loadSection" />
        </div>

        <div id="content">
            <CalendarioVista/>
            <!--
            <div v-if="mainContent=='Calendar'">
                <CalendarioVista />
            </div>
            <div v-if="mainContent=='Notes'">
                <NotasVista />
            </div>
            -->
        </div>
    </div>
    
</template>

<style scoped>
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
    overflow-y: scroll;
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
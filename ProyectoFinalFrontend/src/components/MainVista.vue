<script setup>
import HeaderComponent from './HeaderComponent.vue';
import SidebarComponent from './SidebarComponent.vue';
import NotasVista from './NotasVista.vue';
import '../assets/main.css'
</script>

<template>
    <HeaderComponent />
    <div class="main">
        <div id="sidebar">
            <SidebarComponent />
        </div>

        <div id="content">
            <NotasVista />
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
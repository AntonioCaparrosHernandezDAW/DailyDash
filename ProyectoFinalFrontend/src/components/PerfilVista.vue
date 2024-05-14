<script setup>
    import HeaderComponent from './HeaderComponent.vue';
</script>

<template>
    <HeaderComponent />
    <div id="profileMain">
        <div id="userProfilePicture">

        </div>

        <div id="userUsername">
            <input type="text" value="Antonio5000"><br>
            <button>Editar</button>
        </div>

        <div id="changePassword">
            <button>Cambiar Contraseña</button>
        </div>
    </div>
</template>

<style scoped>
    input{
        text-align: center;
    }

    #profileMain{
        width: 100dvw;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: calc(100dvh - 56px);
        padding: 5%;
        gap: 3%;
    }

    #userProfilePicture{
        outline: 1px solid black;
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }

    #userUsername{
        outline: 1px solid red;
        height: 50px;
    }

    #changePassword{
        outline: 1px solid blue;
        width: 100px;
        height: 50px;
    }
</style>
<script setup>
import { onMounted } from 'vue';

onMounted(()=>{
    console.log("Montando")
    document.querySelector('#initModal').click();
});
</script>

<template>
    <button style="display: none;" id="initModal" data-bs-toggle="modal" data-bs-target="#bannerBox"></button>
    <!--MODAL-->
    <div class="modal fade" id="bannerBox">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="bannerMain">
                        <div id="freePlan">
                            <h1>GRATIS</h1>
                            <b>0€/mes</b>
                            <div class="features">
                                <ul>
                                    <li>Es gratis</li>
                                </ul>
                            </div>
                        </div>

                        <div id="premiumPlan">
                            <h1>PREMIUM</h1>
                            <b>1€/mes</b>
                            <div class="features">
                                <ul>
                                    <li>No es gratis</li>
                                </ul>
                            </div>
                            <button>Comprar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL END-->
</template>

<style scoped>
#bannerMain{
    width: inherit;
    height: 60dvh;
    display: flex;
    justify-content: space-between;
}

#bannerMain > div{
        width: 49%;
        border-radius: 8px;
        padding: 3%;
        height: 100%;
        outline: 1px solid black;
}

.features{
    margin: 4% auto;
    width: 50%;
    text-align: left;
    height: 70%;
}

button{
    padding: 2%;
    background-color: orange;
    border-radius: 10px;
}
</style>
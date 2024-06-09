<script setup>
import router from '../router/index.js'

//Traslada al usuario a /login
const moveToLogin = () => {
    router.push('/login')
}
</script>

<template>
    <div id="inicio"></div>

    <!-- NAVBAR -->
    <div class="navbar navbar-expand-lg navbar">
        <div class="container-fluid">
            <a href="#" class="navbar-brand"><img src="../assets/img/logoDailyDash.png" alt="Logo DailyDash" height="27px"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNavbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapseNavbarContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="#inicio" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="#funcionalidades" class="nav-link">Funcionalidades</a>
                    </li>
                    <li class="nav-item">
                        <a href="#principios" class="nav-link">Principios</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="nav-link" @click="moveToLogin"><b>Empieza ahora</b></button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- FIN NAVBAR -->

    <!-- ESLOGAN -->
    <div class="eslogan">
        <h1><b>Planifica tu tiempo,<br>registra tu día</b></h1>
        <h2>Organiza tu tiempo de forma rápida y sencilla</h2>
    </div>
    <!-- FIN ESLOGAN -->

    <button class="empiezaBoton" @click="moveToLogin">Empieza ahora</button>

    <!-- PRESENTACIÓN FUNCIONALIDADES -->
    <h1 class="sectionTitle" id="funcionalidades">FUNCIONALIDADES</h1>
    <section>
        <img src="../assets/img/muestraNotas.png" alt="Imagen de presentación de la sección 'notas'">
        <div class="texto">
            <h1>Notas</h1>
            <p>¡Lleva tu organización al siguiente nivel con nuestra innovadora funcionalidad de notas! Diseñada
                pensando en tu comodidad y productividad, esta herramienta te permite crear, editar y eliminar notas de
                manera rápida y sencilla.</p>
            <p>¡Empieza a usar nuestra funcionalidad de notas hoy mismo y transforma la manera en que gestionas tu
                información personal y profesional!</p>
        </div>
    </section>

    <section class="ordenInvertido">
        <img src="../assets/img/muestraDiario.png" alt="Imagen de presentación de la sección 'diario'">
        <div class="texto">
            <h1>Diario</h1>
            <p>Nuestra funcionalidad de diario está diseñada para brindarte una manera rápida y sencilla de registrar
                tus días. Con una interfaz intuitiva y accesible, puedes documentar tus pensamientos, actividades y
                emociones en cuestión de segundos. Olvídate de complicaciones y disfruta de una experiencia de usuario
                fluida que te permite concentrarte en lo que realmente importa: capturar cada momento significativo de
                tu vida.</p>
        </div>
    </section>

    <section>
        <img src="../assets/img/muestraCalendario.png" alt="Imagen de presentación de la sección 'calendario'">
        <div class="texto">
            <h1>Calendario</h1>
            <p>¡Lleva tu organización al siguiente nivel con nuestra innovadora funcionalidad de notas! Diseñada
                pensando en tu comodidad y productividad, esta herramienta te permite crear, editar y eliminar notas de
                manera rápida y sencilla.</p>
            <p>¡Empieza a usar nuestra funcionalidad de notas hoy mismo y transforma la manera en que gestionas tu
                información personal y profesional!</p>
        </div>
    </section>

    <section class="ordenInvertido">
        <img src="../assets/img/muestraTareas.png" alt="Imagen de presentación de la sección 'tareas'">
        <div class="texto">
            <h1>Tareas</h1>
            <p>¡Lleva tu organización al siguiente nivel con nuestra innovadora funcionalidad de notas! Diseñada
                pensando en tu comodidad y productividad, esta herramienta te permite crear, editar y eliminar notas de
                manera rápida y sencilla.</p>
            <p>Además, la accesibilidad es una prioridad. Con nuestro diario, puedes acceder a tus entradas en
                cualquier momento y desde cualquier lugar. Mantén tus recuerdos y reflexiones organizados y siempre
                disponibles, sin importar si estás en casa, en el trabajo o en movimiento.</p>
        </div>
    </section>
    <!-- FIN PRESENTACIÓN FUNCIONALIDADES -->

    <!-- SECCIÓN BLOQUES -->
    <h1 class="sectionTitle" id="principios">PRINCIPIOS</h1>
    <div id="bloques">
        <div class="bloque">
            <h1><b>Sencillo</b></h1>
            <p>¡Descubre la simplicidad en la gestión diaria con DailyDash! Esta aplicación ha sido diseñada con la
                premisa de hacer que tu vida sea más fácil. Desde tomar notas rápidas hasta planificar tu semana o
                incluso tu mes, todo
                es intuitivo y fácil de usar. Simplifica tu rutina con DailyDash.</p>
        </div>
        <div class="bloque">
            <h1><b>Adaptable</b></h1>
            <p>Con DailyDash, la adaptabilidad es la clave. Ya sea que estés en casa, en el trabajo o en movimiento,
                nuestra aplicación se ajusta a tu estilo de vida. Accede a tus notas, diario, calendario y tareas desde
                cualquier dispositivo en cualquier momento. DailyDash se adapta a ti, para que puedas mantener tu
                productividad sin importar dónde estés.</p>
        </div>
        <div class="bloque">
            <h1><b>Portable</b></h1>
            <p>Lleva contigo todas tus herramientas de gestión diaria con DailyDash. Nuestra aplicación está diseñada
                para ser totalmente portable, lo que significa que puedes acceder a tu información desde cualquier
                lugar. Ya sea en tu computadora, tableta o teléfono, DailyDash te acompaña a donde vayas, manteniendo tu
                vida organizada en todo momento.</p>
        </div>
        <div class="bloque">
            <h1><b>Potente</b></h1>
            <p>Descubre el poder de la gestión diaria con DailyDash. Nuestra aplicación ofrece una gama completa de
                herramientas para ayudarte a ser más productivo. Desde la creación de listas de tareas hasta el
                seguimiento de tus objetivos, DailyDash te proporciona el poder que necesitas para hacer más en tu día a
                día. Maximiza tu eficiencia con DailyDash.</p>
        </div>
    </div>
    <!-- FIN SECCIÓN BLOQUES -->

    <button class="empiezaBoton" @click="moveToLogin" style="margin-bottom: 10dvh;">Empieza ahora</button>
</template>

<style scoped>
body {
    background-color: #eaeaea;
}

.navbar {
    background-color: var(--navbar);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.338);
    position: sticky;
    top: 0px;
}

.eslogan {
    width: 60%;
    text-align: center;
    margin: 100px auto 50px;
}

.eslogan h1 {
    font-size: 3em;
    margin-bottom: 20px;
    color: #1f1f1f;
}

.eslogan h2 {
    font-size: 1.5em;
    color: #6a6a6a;
}

.empiezaBoton {
    background-color: #0d6efd;
    color: #fff;
    display: block;
    min-width: 12dvw;
    margin: 20px auto;
    padding: 15px 20px;
    border: none;
    border-radius: 25px;
    font-size: 25px;
}

.empiezaBoton:hover {
    background-color: #0c59cd;
}

.sectionTitle {
    text-align: center;
    margin: 10dvh 0;
    font-size: 2.5em;
}

section {
    width: 70%;
    margin: 60px auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    flex-wrap: wrap;
}

section img {
    width: 100%;
    max-width: 45%;
    height: auto;
    border-radius: 10px;
}

section .texto {
    width: 50%;
}

.sectionTitle {
    font-size: 2em;
    margin-bottom: 20px;
    color: #ffab0e;
}

.ordenInvertido{
    flex-direction: row-reverse;
}

#bloques {
    width: 80%;
    margin: 20px auto 7dvh auto;
    display: flex;
    justify-content: space-around;
    gap: 20px;
    flex-wrap: wrap;
}

.bloque {
    border: 1px solid #ddd;
    border-radius: 10px;
    width: calc(25% - 20px);
    min-width: 300px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.31);
    transition: all 0.33s ease;

    & h1 {
        font-size: 1.5em;
        margin-bottom: 15px;
    }
}

.bloque:hover {
    transform: translateY(-5px);
}

@media only screen and (max-width: 1144px) {
    section, .ordenInvertido {
        width: 90%;
        margin: 60px auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }

    section img {
        width: 100%;
        max-width: 55%;
        height: auto;
        border-radius: 10px;
    }

    section .texto {
        width: 75%;
    }

    .sectionTitle {
        font-size: 2em;
        margin-bottom: 20px;
        color: #ffab0e;
    }
}

@media only screen and (max-width: 775px) {
    #bloques{
        width: 300px;
        margin: auto;
    }
}
</style>
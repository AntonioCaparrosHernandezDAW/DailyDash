<script setup>

</script>

<template>
    <!-- NAVBAR -->
    <div class="navbar navbar-expand-lg navbar">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">DailyDash</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseNavbarContent">
                <span class="navbar-toggler-icon" />
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
                        <RouterLink to="/login" class="nav-link">Empieza ahora</RouterLink>
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

    <button class="empiezaBoton">
        Empieza ahora
    </button>

    <!-- PRESENTACIÓN FUNCIONALIDADES -->
    <h1 class="sectionTitle" id="funcionalidades">FUNCIONALIDADES</h1>
    <section>
        <img src="../assets/img/muestraNotas.png" alt="Imagen de presentación de la sección 'notas'">
        <div class="texto">
            <h1>Notas</h1>
            <p>
                ¡Lleva tu organización al siguiente nivel con nuestra innovadora funcionalidad de notas! Diseñada
                pensando en tu comodidad y productividad, esta herramienta te permite crear, editar y eliminar notas de
                manera rápida y sencilla.
            </p>
            <p>
                ¡Empieza a usar nuestra funcionalidad de notas hoy mismo y transforma la manera en que gestionas tu
                información personal y profesional!
            </p>
        </div>
    </section>

    <section>
        <div class="texto">
            <h1>Diario</h1>
            <p>
                Nuestra funcionalidad de diario está diseñada para brindarte una manera rápida y sencilla de registrar
                tus días. Con una interfaz intuitiva y accesible, puedes documentar tus pensamientos, actividades y
                emociones en cuestión de segundos. Olvídate de complicaciones y disfruta de una experiencia de usuario
                fluida que te permite concentrarte en lo que realmente importa: capturar cada momento significativo de
                tu vida.
            </p>
        </div>
        <img src="../assets/img/muestraDiario.png" alt="Imagen de presentación de la sección 'diario'">
    </section>

    <section>
        <img src="../assets/img/muestraCalendario.png" alt="Imagen de presentación de la sección 'calendario'">
        <div class="texto">
            <h1>Calendario</h1>
            <p>
                ¡Lleva tu organización al siguiente nivel con nuestra innovadora funcionalidad de notas! Diseñada
                pensando en tu comodidad y productividad, esta herramienta te permite crear, editar y eliminar notas de
                manera rápida y sencilla.
            </p>
            <p>
                ¡Empieza a usar nuestra funcionalidad de notas hoy mismo y transforma la manera en que gestionas tu
                información personal y profesional!
            </p>
        </div>
    </section>

    <section>
        <div class="texto">
            <h1>Tareas</h1>
            <p>
                ¡Lleva tu organización al siguiente nivel con nuestra innovadora funcionalidad de notas! Diseñada
                pensando en tu comodidad y productividad, esta herramienta te permite crear, editar y eliminar notas de
                manera rápida y sencilla.
            </p>
            <p>
                Además, la accesibilidad es una prioridad. Con nuestro diario, puedes acceder a tus entradas en
                cualquier momento y desde cualquier lugar. Mantén tus recuerdos y reflexiones organizados y siempre
                disponibles, sin importar si estás en casa, en el trabajo o en movimiento. Nuestra funcionalidad de
                diario no solo te ayuda a mantener un registro de tu vida, sino que también te proporciona una
                herramienta poderosa para la auto-reflexión y el crecimiento personal, todo con la rapidez y sencillez
                que mereces.
            </p>
        </div>
        <img src="../assets/img/muestraTareas.png" alt="Imagen de presentación de la sección 'tareas'">
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

    <!-- EMPIEZA AHORA -->
    <button class="empiezaBoton">
        Empieza ahora
    </button>
    <!-- FIN EMPIEZA AHORA -->
</template>

<style scoped>
/* Mejoras generales */
body {
    font-family: Arial, sans-serif;
    color: #333;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.navbar {
    background-color: #ffab0e;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.navbar-brand {
    font-weight: bold;
    color: #fff;
}

.nav-link {
    color: #fff;
}

.nav-link:hover {
    color: #ddd;
}

.empiezaBoton {
    background-color: #8bc34a;
    color: #fff;
    display: block;
    width: 200px;
    margin: 20px auto;
    padding: 15px 20px;
    border: none;
    border-radius: 25px;
    font-size: 18px;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.empiezaBoton:hover {
    background-color: #7cb342;
}

.sectionTitle {
    text-align: center;
    margin: 50px 0;
    font-size: 2.5em;
    color: #444;
}

#bloques {
    width: 80%;
    margin: auto;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}

.bloque {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    width: calc(25% - 20px);
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.bloque:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.bloque h1 {
    font-size: 1.5em;
    margin-bottom: 15px;
}

.bloque p {
    font-size: 1em;
    line-height: 1.5;
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
    width: 45%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

section .texto {
    width: 50%;
}

.sectionTitle {
    font-size: 2em;
    margin-bottom: 20px;
    color: #ffab0e;
}

.eslogan {
    width: 60%;
    text-align: center;
    margin: 100px auto 50px;
}

.eslogan h1 {
    font-size: 3em;
    margin-bottom: 20px;
    color: #444;
}

.eslogan h2 {
    font-size: 1.5em;
    color: #666;
}

</style>
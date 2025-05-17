document.addEventListener("DOMContentLoaded", async () => {
    const sliderMovil = document.getElementById("slider");
    const sliderEscritorio = document.getElementById("slider-escritorio");

    if (!sliderMovil || !sliderEscritorio) return;

    const idCine = localStorage.getItem("cineSeleccionado") || "";
    let url = "/Proyecto-Nostromo/servicios_rest/proximos-lanzamientos";
    if (idCine) url += `?id_cine=${idCine}`;

    try {
        const res = await fetch(url);
        const datos = await res.json();
        const lanzamientos = datos.lanzamientos || [];

        if (!lanzamientos.length) {
            sliderMovil.innerHTML = "<li><p>No hay próximos lanzamientos disponibles.</p></li>";
            sliderEscritorio.innerHTML = "<li><p>No hay próximos lanzamientos disponibles.</p></li>";
            return;
        }

        lanzamientos.forEach(peli => {
            const html = crearSlideHTML(peli);
            sliderMovil.insertAdjacentHTML("beforeend", html);
            sliderEscritorio.insertAdjacentHTML("beforeend", html);
        });

        // Iniciar sliders
        $("#slider").lightSlider({
            item: 2,
            auto: true,
            loop: true,
            pause: 5000
        });

        $("#slider-escritorio").lightSlider({
            item: 1,
            auto: true,
            loop: true,
            pause: 10000
        });

    } catch (error) {
        console.error("Error al cargar lanzamientos:", error);
        sliderMovil.innerHTML = "<li><p>Error al cargar próximos lanzamientos.</p></li>";
        sliderEscritorio.innerHTML = "<li><p>Error al cargar próximos lanzamientos.</p></li>";
    }

    function crearSlideHTML(peli) {
        return `
            <li>
                <article class="item">
                    <a href="#">
                        <picture>
                            <source srcset="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${peli.foto}-tablet.png" media="(min-width:600px)">
                            <img src="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${peli.foto}-mobile.png" alt="cartel-${peli.titulo}">
                        </picture>
                    </a>
                    <h2>${peli.titulo}</h2>
                    <a href="#"><p>Sinopsis</p></a>
                </article>
            </li>
        `;
    }
});

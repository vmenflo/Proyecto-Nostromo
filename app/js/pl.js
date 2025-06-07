document.addEventListener("DOMContentLoaded", async () => {
    const sliderMovil = document.getElementById("slider");
    const sliderEscritorio = document.getElementById("slider-escritorio");

    if (!sliderMovil || !sliderEscritorio) return;

    let url = `${API_BASE}/proximos-lanzamientos`;

    // Solo filtrar por cine si estamos en la vista "proximamente"
    if (window.location.href.includes("vista=proximamente")) {
        const idCine = localStorage.getItem("cineSeleccionado");
        if (idCine) url += `?id_cine=${idCine}`;
    }

    try {
        const res = await fetch(url);
        const datos = await res.json();
        const lanzamientos = datos.lanzamientos || [];

        sliderMovil.innerHTML = "";
        sliderEscritorio.innerHTML = "";

        if (!lanzamientos.length) {
            sliderMovil.innerHTML = "<li><p>No hay próximos lanzamientos disponibles.</p></li>";
            sliderEscritorio.innerHTML = "<li><p>No hay próximos lanzamientos disponibles.</p></li>";
            return;
        }

        lanzamientos.forEach(peli => {
            sliderMovil.insertAdjacentHTML("beforeend", crearSlideHTML(peli, "mobile"));
            sliderEscritorio.insertAdjacentHTML("beforeend", crearSlideHTML(peli, "escritorio"));
        });

        $("#slider").lightSlider({ item: 2, auto: true, loop: true, pause: 5000 });
        $("#slider-escritorio").lightSlider({ item: 1, auto: true, loop: true, pause: 10000 });

    } catch (error) {
        console.error("Error al cargar lanzamientos:", error);
        sliderMovil.innerHTML = "<li><p>Error al cargar próximos lanzamientos.</p></li>";
        sliderEscritorio.innerHTML = "<li><p>Error al cargar próximos lanzamientos.</p></li>";
    }

    function crearSlideHTML(peli, tipo = "mobile") {
        if (tipo === "escritorio") {
            return `
                <li>
                    <article class="item-pl">
                        <div class="contenedor-info">
                            <p>${peli.titulo}</p>
                            <p>${peli.sinopsis}</p>
                        </div>
                        <a href="index.php?vista=proximamente">
                            <img src="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${peli.foto}-slider.png" alt="cartel-${peli.titulo}">
                        </a>
                    </article>
                </li>
            `;
        } else {
            return `
                <li>
                    <article class="item-pl">
                        <a href="index.php?vista=proximamente">
                            <picture>
                                <source srcset="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${peli.foto}-tablet.png" media="(min-width:600px)">
                                <img src="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${peli.foto}-mobile.png" alt="cartel-${peli.titulo}">
                            </picture>
                        </a>
                        <h2>${peli.titulo}</h2>
                    </article>
                </li>
            `;
        }
    }
});

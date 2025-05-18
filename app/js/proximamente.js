document.addEventListener("DOMContentLoaded", async () => {
    const select = document.getElementById("elegir-cine");
    const cartelera = document.getElementById("cartelera");

    if (!select || !cartelera) return;

    const urlCines = select.dataset.url;
    const cineGuardado = localStorage.getItem("cineSeleccionado") || "";

    // Cargar lista de cines
    try {
        const res = await fetch(urlCines);
        const datos = await res.json();

        if (datos.cines) {
            select.innerHTML = '<option value=""> - Elige tu cine favorito - </option>';
            datos.cines.forEach(cine => {
                const option = document.createElement("option");
                option.value = cine.id_cine;
                option.textContent = cine.nombre;
                if (cine.id_cine == cineGuardado) option.selected = true;
                select.appendChild(option);
            });

            await cargarLanzamientos(cineGuardado);
        }
    } catch (err) {
        console.error("Error cargando cines:", err);
    }

    // Cambiar cine seleccionado
    select.addEventListener("change", async () => {
        const id = select.value;
        if (id) {
            localStorage.setItem("cineSeleccionado", id);
        } else {
            localStorage.removeItem("cineSeleccionado");
        }
        await cargarLanzamientos(id);
    });

    async function cargarLanzamientos(idCine = "") {
        try {
            let url = "/Proyecto-Nostromo/servicios_rest/proximos-lanzamientos";
            if (idCine) url += `?id_cine=${idCine}`;

            const res = await fetch(url);
            const datos = await res.json();
            const lanzamientos = datos.lanzamientos || [];

            renderizarLanzamientos(lanzamientos);
        } catch (err) {
            console.error("Error al cargar lanzamientos:", err);
            cartelera.innerHTML = "<p>Error al cargar los próximos lanzamientos.</p>";
        }
    }

    function renderizarLanzamientos(lista) {
        if (!lista.length) {
            cartelera.innerHTML = "<p>No hay próximos lanzamientos disponibles.</p>";
            return;
        }

        cartelera.innerHTML = lista.map(p => `
        <div class="cont-pelicula">
        <div class="tarjeta">
        <picture>
            <source media="(min-width: 1024px)"
                    srcset="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${p.foto}-desktop.png">
            <source media="(min-width: 768px)"
                    srcset="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${p.foto}-tablet.png">
            <img class="foto-cartelera"
                src="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${p.foto}-mobile.png"
                alt="foto-cartelera">
        </picture>
            <p class="prox">proximamente</p>
            <p class="cartel-titulo">${p.titulo}</p>
            <p> Fecha : ${p.fecha_estreno} </p>
            <p> Genero : ${p.genero}  </p>
            <p class="sinopsis">${p.sinopsis}</p>
            </div>
        </div>
        `).join('');
    }
});

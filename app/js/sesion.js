document.addEventListener("DOMContentLoaded", async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const idPelicula = urlParams.get("id_pelicula");
    const idCine = urlParams.get("id_cine");

    const selectCine = document.getElementById("select-cine");
    const contInfo = document.getElementById("cont-info");
    const contSesiones = document.getElementById("cont-sesiones");
    const selectFecha = document.getElementById("select-fecha");
    const selectHora = document.getElementById("select-hora");

    if (!idPelicula) {
        contInfo.innerHTML = "<p>Película no especificada</p>";
        return;
    }

    // Traer datos de la película
    try {
        const resPeli = await fetch(`/Proyecto-Nostromo/servicios_rest/pelicula/${idPelicula}`);
        const datosPeli = await resPeli.json();

        if (datosPeli.error) {
            contInfo.innerHTML = `<p>Error: ${datosPeli.error}</p>`;
        } else {
            const p = datosPeli.pelicula;
            contInfo.innerHTML = `
                <h1>${p.titulo}</h1>
                <div class="linea"></div>
                <div id="cont-video">
                    <iframe src="${p.url_trailer}" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                </div>
                <div id="contenedor-info">
                    <div id="ficha">
                        <h2>Ficha</h2>
                        <p><strong>Director:</strong> ${p.director}</p>
                        <p><strong>Duración:</strong> ${p.duracion} min</p>
                        <p><strong>Género:</strong> ${p.genero}</p>
                    </div>
                    <div id="sinopsis">
                        <h2>Sinopsis</h2>
                        <p>${p.sinopsis}</p>
                    </div>
                </div>
            `;
        }
    } catch (err) {
        contInfo.innerHTML = `<p>Error al cargar película</p>`;
        console.error(err);
    }

    // Cargar cines disponibles
    try {
        const resCines = await fetch(`/Proyecto-Nostromo/servicios_rest/proyecciones/cines/${idPelicula}`);
        const datos = await resCines.json();

        if (datos.error) {
            selectCine.innerHTML = `<option value="">${datos.error}</option>`;
            return;
        }

        const cines = datos.cines;
        if (!cines.length) {
            selectCine.innerHTML = `<option value="">No hay cines disponibles</option>`;
            return;
        }

        selectCine.innerHTML = '<option value="">- Elige tu cine -</option>';
        cines.forEach(cine => {
            const option = document.createElement("option");
            option.value = cine.id_cine;
            option.textContent = cine.nombre;
            if (idCine && cine.id_cine == idCine) {
                option.selected = true;
            }
            selectCine.appendChild(option);
        });

        // Si venía cine por URL, cargar sesiones automáticamente
        if (idCine) {
            cargarSesiones(idCine, idPelicula);
        }

    } catch (err) {
        selectCine.innerHTML = `<option value="">Error al cargar cines</option>`;
        console.error(err);
    }

    // Al cambiar el cine
    selectCine.addEventListener("change", e => {
        const idSeleccionado = e.target.value;
        if (idSeleccionado) {
            cargarSesiones(idSeleccionado, idPelicula);
        } else {
            // Solo reseteamos los selects de fecha y hora
            selectFecha.innerHTML = '<option value="">Selecciona primero</option>';
            selectHora.innerHTML = '<option value="">Selecciona primero</option>';
        }
    });

    // Función para cargar sesiones por cine y película
    async function cargarSesiones(idCine, idPelicula) {
        selectFecha.innerHTML = '<option>Cargando fechas...</option>';
        selectHora.innerHTML = '<option>Selecciona una fecha primero</option>';

        try {
            const res = await fetch(`/Proyecto-Nostromo/servicios_rest/sesiones/${idCine}/${idPelicula}`);
            const datos = await res.json();

            if (datos.error) {
                contSesiones.innerHTML = `<p>Error: ${datos.error}</p>`;
                return;
            }

            const sesiones = datos.sesiones || [];
            if (!sesiones.length) {
                contSesiones.innerHTML = "<p>No hay sesiones disponibles.</p>";
                return;
            }

            // Agrupar sesiones por fecha
            const sesionesPorFecha = {};
            sesiones.forEach(s => {
                if (!sesionesPorFecha[s.fecha]) sesionesPorFecha[s.fecha] = [];
                sesionesPorFecha[s.fecha].push(s.hora);
            });

            // Pintar las fechas
            selectFecha.innerHTML = '<option value="">Selecciona una fecha</option>';
            Object.keys(sesionesPorFecha).forEach(fecha => {
                const opt = document.createElement("option");
                opt.value = fecha;
                opt.textContent = fecha;
                selectFecha.appendChild(opt);
            });

            // Cuando el usuario elija una fecha, cargamos las horas
            selectFecha.addEventListener("change", () => {
                const fechaSeleccionada = selectFecha.value;
                const horas = sesionesPorFecha[fechaSeleccionada] || [];

                selectHora.innerHTML = '<option value="">Selecciona una hora</option>';
                horas.forEach(hora => {
                    const opt = document.createElement("option");
                    opt.value = hora;
                    opt.textContent = hora;
                    selectHora.appendChild(opt);
                });
            });

        } catch (err) {
            contSesiones.innerHTML = `<p>Error al cargar sesiones.</p>`;
            console.error(err);
        }
    }

    // Botón comprar
    const botonComprar = document.querySelector(".logo-boton a");

    botonComprar.addEventListener("click", (e) => {
        e.preventDefault();
        const idCine = document.getElementById("select-cine").value;
        const fecha = document.getElementById("select-fecha").value;
        const hora = document.getElementById("select-hora").value;

        if (!idCine || !fecha || !hora) {
            alert("Debes seleccionar un cine, una fecha y una hora antes de comprar.");
            return;
        }

        const idPelicula = new URLSearchParams(window.location.search).get("id_pelicula");

        // Redirigir a la vista de butaca con los parámetros
        window.location.href = `/Proyecto-Nostromo/app/index.php?vista=butacas&id_pelicula=${idPelicula}&id_cine=${idCine}&fecha=${fecha}&hora=${hora}`;
    });

});



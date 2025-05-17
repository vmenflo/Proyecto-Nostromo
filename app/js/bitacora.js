document.addEventListener("DOMContentLoaded", () => {
    const contenedorArticulos = document.getElementById("contenedor-articulos");
    const contenedorDetalle = document.getElementById("detalle-articulo");

    if (contenedorArticulos) {
        fetchArticulos();
    }

    if (contenedorDetalle) {
        const params = new URLSearchParams(window.location.search);
        const id = params.get("id");
        if (id) {
            fetchArticulo(id);
        } else {
            contenedorDetalle.innerHTML = "<p>No se ha especificado un artículo.</p>";
        }
    }
});

function fetchArticulos() {
    fetch("http://localhost/Proyecto-Nostromo/servicios_rest/articulos")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                mostrarError(data.error, "contenedor-articulos");
            } else if (data.mensaje) {
                mostrarMensaje(data.mensaje, "contenedor-articulos");
            } else if (data.articulos) {
                mostrarArticulos(data.articulos);
            }
        })
        .catch(error => {
            mostrarError("Error al obtener los artículos: " + error, "contenedor-articulos");
        });
}

function mostrarArticulos(articulos) {
    const contenedor = document.getElementById("contenedor-articulos");
    contenedor.innerHTML = "";

    articulos.forEach(articulo => {
        const div = document.createElement("div");
        div.classList.add("articulo");
        div.innerHTML = `
            <div class="tarjetas-articulos">
                <h3>${articulo.titulo}</h3>
                <picture>
                    <source media="(min-width: 1024px)"
                            srcset="https://nostromo-media.s3.eu-north-1.amazonaws.com/articulos/${articulo.foto}-desktop.png">
                    <img class="foto-articulos"
                        src="https://nostromo-media.s3.eu-north-1.amazonaws.com/articulos/${articulo.foto}-mobile.png"
                        alt="foto-cartelera">
                </picture>
                <p>${articulo.resumen} 
                    <a class="enlace-bitacora" href="${BASE_URL}index.php?vista=detalle-bitacora&id=${articulo.id_articulo}">
                        Ver el post entero
                    </a>
                </p>
            </div>
        `;
        contenedor.appendChild(div);
    });
}

function fetchArticulo(id) {
    fetch(`http://localhost/Proyecto-Nostromo/servicios_rest/articulo/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                mostrarError(data.error, "detalle-articulo");
            } else if (data.mensaje) {
                mostrarMensaje(data.mensaje, "detalle-articulo");
            } else if (data.articulo) {
                const a = data.articulo;
                const contenedor = document.getElementById("detalle-articulo");

                const cuerpoFormateado = a.descripcion
                    .split("||")
                    .filter(p => p.trim() !== "")
                    .map(p => `<p>${p.trim()}</p>`)
                    .join("");

                contenedor.innerHTML = `
                    <div>
                        <h2>${a.titulo}</h2>
                        <picture>
                            <source media="(min-width: 1024px)"
                                srcset="https://nostromo-media.s3.eu-north-1.amazonaws.com/articulos/${a.foto}-desktop.png">
                            <img class="foto-articulos"
                                src="https://nostromo-media.s3.eu-north-1.amazonaws.com/articulos/${a.foto}-mobile.png"
                                alt="foto-articulo">
                        </picture>
                        ${cuerpoFormateado}
                        <p><a class="enlace-bitacora" href="${BASE_URL}index.php?vista=bitacora">← Volver a bitácora</a></p>
                    </div>
                `;
            }
        })
        .catch(err => {
            mostrarError("Error al cargar el artículo: " + err, "detalle-articulo");
        });
}


function mostrarError(mensaje, idContenedor) {
    const contenedor = document.getElementById(idContenedor);
    contenedor.innerHTML = `<p style="color: red;">${mensaje}</p>`;
}

function mostrarMensaje(mensaje, idContenedor) {
    const contenedor = document.getElementById(idContenedor);
    contenedor.innerHTML = `<p>${mensaje}</p>`;
}

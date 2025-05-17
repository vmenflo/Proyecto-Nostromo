document.addEventListener("DOMContentLoaded", () => {
    fetchArticulos();
});

function fetchArticulos() {
    fetch("http://localhost/Proyecto-Nostromo/servicios_rest/articulos")
    .then(response => response.json())
        .then(data => {
            if (data.error) {
                mostrarError(data.error);
            } else if (data.mensaje) {
                mostrarMensaje(data.mensaje);
            } else if (data.articulos) {
                mostrarArticulos(data.articulos);
            }
        })
        .catch(error => {
            mostrarError("Error al obtener los artículos: " + error);
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
            <p>${articulo.resumen} <a href="${BASE_URL}index.php?vista=detalle-bitacora">Ver el post entero</a></p>
            </div>
        `;
        contenedor.appendChild(div);
    });
}

function mostrarError(mensaje) {
    const contenedor = document.getElementById("contenedor-articulos");
    contenedor.innerHTML = `<p style="color: red;">${mensaje}</p>`;
}

function mostrarMensaje(mensaje) {
    const contenedor = document.getElementById("contenedor-articulos");
    contenedor.innerHTML = `<p>${mensaje}</p>`;
}

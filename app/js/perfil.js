document.addEventListener("DOMContentLoaded", () => {
    const token = localStorage.getItem("token");

    if (!token) {
        alert("No tienes una sesión activa. Por favor, inicia sesión.");
        window.location.href = "index.php?vista=login";
        return;
    }

    fetch("/Proyecto-Nostromo/servicios_rest/reservas", {
        method: "GET",
        headers: {
            "Authorization": "Bearer " + token
        }
    })
        .then(res => res.json())
        .then(data => {
            if (data.no_auth) {
                alert("Sesión expirada o inválida. Iniciá sesión nuevamente.");
                window.location.href = "index.php?vista=login";
                return;
            }

            if (data.codigo === "success") {
                pintarEntradasFuturas(data.futuras);
                pintarHistorial(data.historial);
            } else {
                console.error("Error en el servidor:", data.mensaje);
            }
        })
        .catch(error => {
            console.error("Error de red:", error);
            alert("No se pudo conectar con el servidor.");
        });
});

function crearTarjetaReserva(entrada) {
    const div = document.createElement("div");
    div.classList.add("entrada");

    const picture = document.createElement("picture");

    const source = document.createElement("source");
    source.media = "(min-width: 768px)";
    source.srcset = `https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${entrada.foto}-tablet.png`;

    const img = document.createElement("img");
    img.classList.add("foto-cartelera");
    img.src = `https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${entrada.foto}-mobile.png`;
    img.alt = entrada.titulo;

    picture.appendChild(source);
    picture.appendChild(img);

    const info = document.createElement("div");
    info.classList.add("entrada-info");

    const fechaObj = new Date(entrada.fecha);
    const fechaFormateada = `${fechaObj.getDate()}/${fechaObj.getMonth() + 1}/${fechaObj.getFullYear()}`;

    const butacas = entrada.butacas?.split(', ') || [];
    const fila = butacas.length > 0 ? butacas[0].match(/^F(\d+)B/)[1] : "?";
    const butacasSolo = butacas.map(b => b.replace(/^F\d+B/, b.match(/B\d+/)[0])).join(', ') || "Sin info";

    info.innerHTML = `
        <p><strong>${entrada.titulo}</strong></p>
        <p>Cine: ${entrada.cine} &nbsp;&nbsp;&nbsp; Sala: ${entrada.sala || "?"}</p>
        <p>Sesión: ${entrada.hora.slice(0, 5)}H &nbsp;&nbsp;&nbsp; Fecha: ${fechaFormateada}</p>
        <p>Fila: ${fila} &nbsp;&nbsp;&nbsp; Butacas: ${butacasSolo}</p>
    `;

    div.appendChild(picture);
    div.appendChild(info);

    return div;
}


function pintarEntradasFuturas(futuras) {
    const contenedor = document.getElementById("entradas-futuras");
    contenedor.innerHTML = futuras.length === 0
        ? "<p>No tienes entradas futuras.</p>"
        : "";

    futuras.forEach(entrada => {
        contenedor.appendChild(crearTarjetaReserva(entrada));
    });
}

function pintarHistorial(historial) {
    const contenedor = document.getElementById("entradas-historial");
    contenedor.innerHTML = historial.length === 0
        ? "<p>No hay historial de entradas.</p>"
        : "";

    historial.forEach(entrada => {
        contenedor.appendChild(crearTarjetaReserva(entrada));
    });
}

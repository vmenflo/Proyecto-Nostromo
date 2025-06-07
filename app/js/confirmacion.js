document.addEventListener('DOMContentLoaded', () => {

    const urlParams = new URLSearchParams(window.location.search);
    const id_pelicula = urlParams.get("id_pelicula");
    const id_cine = urlParams.get("id_cine");
    const id_sala = urlParams.get("id_sala");
    const fecha = urlParams.get("fecha");
    const hora = urlParams.get("hora");
    const subtotal = urlParams.get("subtotal");
    const butacas = urlParams.get("butacas");

    if (id_pelicula) {
        fetch(`${API_BASE}/pelicula/${id_pelicula}`)
            .then(res => {
                if (!res.ok) throw new Error(`Error HTTP: ${res.status}`);
                return res.json();
            })
            .then(data => {
                if (data.error) throw new Error(data.error);
                const p = data.pelicula;

                document.querySelector('.pelicula').innerHTML = `
            <picture>
                <source media="(min-width: 768px)"
                        srcset="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${p.foto}-tablet.png">
                <img class="foto-cartelera"
                     src="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/${p.foto}-mobile.png"
                     alt="${p.titulo}">
            </picture>
            <p class='titulo'>${p.titulo}</p>
          `;
            })
            .catch(() => {
                document.querySelector('.pelicula').innerHTML = `<p>Error al cargar datos</p>`;
            });
    }

    document.getElementById("btn-continuar-confirmacion")?.addEventListener("click", (e) => {
        e.preventDefault();

        const params = new URLSearchParams({
            id_cine,
            id_pelicula,
            id_sala,
            fecha,
            hora,
            subtotal,
            butacas
        });

        window.location.href = `/index.php?vista=pago&${params.toString()}`;
    });

    document.getElementById("btn-cancelar-confirmacion")?.addEventListener("click", (e) => {
        e.preventDefault();

        window.location.href = `/index.php?vista=inicio.php`;
    });

});

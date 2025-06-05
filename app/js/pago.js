document.addEventListener('DOMContentLoaded', () => {
    const numTarjeta = document.getElementById('num_tarjeta');
    const cadMes = document.getElementById('cad_mes');
    const cadAnio = document.getElementById('cad_anio');
    const codigo = document.getElementById('codigo');

    const btnPagar = document.querySelector('.boton-pagar a');
    const btnCancelar = document.querySelector('.boton-cancelar a');

    const urlParams = new URLSearchParams(window.location.search);
    const id_cine = urlParams.get("id_cine");
    const id_pelicula = urlParams.get("id_pelicula");
    const fecha = urlParams.get("fecha");
    const hora = urlParams.get("hora");
    const subtotal = urlParams.get("subtotal");
    const butacas = urlParams.get("butacas")?.split(",") || [];

    btnCancelar.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = "/Proyecto-Nostromo/app/index.php";
    });

    btnPagar.addEventListener('click', (e) => {
        e.preventDefault();

        const tarjeta = numTarjeta.value.trim();
        const mes = parseInt(cadMes.value);
        let anio = parseInt(cadAnio.value);

        // Convertir año de 2 dígitos a 4 (asumimos siglo 21)
        if (!isNaN(anio) && anio < 100) {
            anio += 2000;
        }

        const hoy = new Date();
        const mesActual = hoy.getMonth() + 1;
        const anioActual = hoy.getFullYear();

        // Validaciones
        if (
            tarjeta.endsWith('0') ||
            isNaN(mes) || isNaN(anio) ||
            anio < anioActual ||
            (anio === anioActual && mes < mesActual)
        ) {
            alert("Introduce una tarjeta válida.");
            return;
        }

        const datos = {
            id_usuario,
            id_cine,
            id_pelicula,
            fecha,
            hora,
            id_sala,
            butacas,
            subtotal
        };


        fetch(`${API_BASE}/reservar`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(datos)
        })
        .then(res => res.ok ? res.json() : Promise.reject(`HTTP ${res.status}`))
        .then(data => {
            if (data.error) {
                alert("Error: " + data.error);
                return;
            }

            alert("Pago realizado correctamente. Ya puedes ver las entradas en tu perfil");
            window.location.href = `${URL_BASE}/index.php`;
        })
        .catch(err => {
            console.error("Error en reserva:", err);
            alert("Error realizando la reserva.");
        });
    });
});

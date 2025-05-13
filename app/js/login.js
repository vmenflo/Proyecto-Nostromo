document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-login");
    const correoInput = document.getElementById("correo");
    const claveInput = document.getElementById("clave");
    const errorCorreo = document.getElementById("error-correo");
    const errorClave = document.getElementById("error-clave");
    const mensajeError = document.getElementById("mensaje-error");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        errorCorreo.textContent = "";
        errorClave.textContent = "";
        mensajeError.textContent = "";

        const correo = correoInput.value.trim();
        const clave = claveInput.value.trim();

        let error = false;

        if (correo === "") {
            errorCorreo.textContent = "* Campo vacío *";
            error = true;
        }

        if (clave === "") {
            errorClave.textContent = "* Campo vacío *";
            error = true;
        }

        if (error) return;

        try {
            const res = await fetch("/Proyecto-Nostromo/app/servicios/login.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ correo, clave })
            });

            const data = await res.json();

            if (data.status === "ok") {
                window.location.href = "/Proyecto-Nostromo/app/index.php";
            } else {
                mensajeError.textContent = data.mensaje;
            }

        } catch (err) {
            mensajeError.textContent = "Error de conexión con el servidor.";
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-registro");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const nombre = document.getElementById("nombre").value.trim();
        const apellidos = document.getElementById("apellidos").value.trim();
        const correo = document.getElementById("correo").value.trim();
        const clave = document.getElementById("clave").value.trim();
        const suscripcion = document.querySelector('input[name="suscripcion"]:checked')?.value || "0";
        const telefono = document.getElementById("telefono").value.trim();

        if (!nombre || !apellidos || !correo || !clave || !telefono) {
            alert("Por favor, completa todos los campos.");
            return;
        }        

        try {
            const res = await fetch(`${URL_BASE}/servicios/registro.php`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                credentials: "include",
                body: JSON.stringify({ nombre, apellidos, correo, clave, suscripcion, telefono})
            });

            const data = await res.json();

            if (data.status === "ok") {
                const redir = redirParam;
                if (redir) {
                    const redirParams = new URLSearchParams(redir);
                    window.location.href = `${URL_BASE}/index.php?${redirParams.toString()}`;
                } else {
                    window.location.href = `${URL_BASE}/index.php`;
                }
            } else {
            alert(data.mensaje || "Error desconocido durante el registro.");
        }
        } catch (err) {
            alert("Error de conexión con el servidor.");
        }
    });
});

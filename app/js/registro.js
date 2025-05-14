document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-registro");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const nombre = document.getElementById("nombre").value.trim();
        const apellidos = document.getElementById("apellidos").value.trim();
        const correo = document.getElementById("correo").value.trim();
        const clave = document.getElementById("clave").value.trim();
        const suscripcion = document.querySelector('input[name="suscripcion"]:checked')?.value || "0";

        if (!nombre || !apellidos || !correo || !clave) {
            alert("Por favor, completa todos los campos.");
            return;
        }

        try {
            const res = await fetch("/Proyecto-Nostromo/app/servicios/registro.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                credentials: "include",
                body: JSON.stringify({ nombre, apellidos, correo, clave, suscripcion })
            });

            const data = await res.json();

            if (data.status === "ok") {
                alert("Usuario registrado correctamente.");
                window.location.href = "/Proyecto-Nostromo/app/index.php";
            } else {
                alert(data.mensaje || "Error al registrar.");
            }

        } catch (err) {
            alert("Error de conexión con el servidor.");
        }
    });
});

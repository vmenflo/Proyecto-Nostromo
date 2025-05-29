document.addEventListener("DOMContentLoaded", async () => {
    const contenedor = document.getElementById("cines-activos");
    const contDinamico = document.getElementById("cont-dinamico");

    try {
        const res = await fetch("/Proyecto-Nostromo/servicios_rest/cines", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("token")
            }
        });

        if (!res.ok) throw new Error("Error al cargar cines");

        const datos = await res.json();

        if (Array.isArray(datos.cines)) {
            contenedor.innerHTML = "";

            datos.cines.forEach((cine, index) => {
                const div = document.createElement("div");
                div.classList.add("bloque-cine");

                div.innerHTML = `
                    <div class="tarjeta-cine">
                        <span class="num">${index + 1}.</span>
                        <span class="nombre" data-id="${cine.id_cine}" style="cursor:pointer">${cine.nombre}</span>
                        <span class="acciones">
                            <svg class="editar" data-id="${cine.id_cine}" width="38" height="37" viewBox="0 0 38 37">
                            <g clip-path="url(#clip0_4222_1449)">
                                <path d="M2.375 32.375V4.625C2.375 3.34908 3.44197 2.3125 4.75 2.3125H28.5C29.8104 2.3125 30.875 3.34908 30.875 4.625V18.2199L33.25 15.9074V4.625C33.25 2.07084 31.1232 0 28.5 0H4.75C2.12681 0 0 2.07084 0 4.625V32.375C0 34.9292 2.12681 37 4.75 37H17.8125V34.6875H4.75C3.44197 34.6875 2.375 33.6509 2.375 32.375ZM26.125 6.9375H7.125V9.25H26.125V6.9375ZM26.125 11.5625H7.125V13.875H26.125V11.5625ZM26.125 16.1875H7.125V18.5H26.125V16.1875ZM7.125 23.125H16.625V20.8125H7.125V23.125ZM37.3041 20.8125L35.625 19.1776C35.161 18.7258 34.5536 18.5 33.9459 18.5C33.3382 18.5 32.7305 18.7258 32.2668 19.1776L22.0709 29.1051C21.6069 29.5566 20.1875 31.3034 20.1875 31.8952L19 37L24.2416 35.8438C24.2416 35.8438 26.6445 34.4617 27.1082 34.0099L37.3041 24.0824C38.2319 23.1793 38.2319 21.7147 37.3041 20.8125ZM26.2711 33.1902C26.1366 33.3145 25.6714 33.6203 25.1032 33.9726L22.0266 30.9771C22.3422 30.5559 22.6934 30.1325 22.9104 29.9226L30.5873 22.4477L33.9459 25.7179L26.2711 33.1902Z" fill="white"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_4222_1449">
                                <rect width="38" height="37" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                            <svg class="eliminar" data-id="${cine.id_cine}" width="33" height="33" viewBox="0 0 33 33">
                                <path d="M30.2975 26.4996L21.5476 16.5002L30.2975 6.50008C31.7844 5.01257 31.7844 2.60171 30.2975 1.11484C28.8094 -0.372036 26.3985 -0.371401 24.9123 1.11547L16.4993 10.731L8.08642 1.11547C6.59954 -0.370767 4.18932 -0.371402 2.70117 1.11484C1.2143 2.60235 1.2143 5.01321 2.70117 6.50008L11.4511 16.5002L2.70117 26.4996C1.2143 27.9865 1.2143 30.3973 2.70054 31.8842C4.18805 33.3717 6.59891 33.3717 8.08642 31.8842L16.4993 22.2687L24.9123 31.8842C26.4004 33.3717 28.8113 33.3717 30.2982 31.8842C31.7844 30.3973 31.7844 27.9865 30.2975 26.4996Z" fill="white"/>
                            </svg>
                        </span>
                    </div>
                `;

                contenedor.appendChild(div);
            });

            // Botón agregar
            const agregar = document.createElement("div");
            agregar.classList.add("bloque-agregar");
            agregar.innerHTML = `
                <svg class="agregar" id="btn-agregar" width="54" height="54" viewBox="0 0 54 54">
                    <path d="M29.7 13.5H24.3V24.3H13.5V29.7H24.3V40.5H29.7V29.7H40.5V24.3H29.7V13.5ZM27 0C12.15 0 0 12.15 0 27C0 41.85 12.15 54 27 54C41.85 54 54 41.85 54 27C54 12.15 41.85 0 27 0ZM27 48.6C15.12 48.6 5.4 38.88 5.4 27C5.4 15.12 15.12 5.4 27 5.4C38.88 5.4 48.6 15.12 48.6 27C48.6 38.88 38.88 48.6 27 48.6Z" fill="white"/>
                </svg>
            `;
            contenedor.appendChild(agregar);

            // Eventos
            document.querySelectorAll(".nombre").forEach(el => {
                el.addEventListener("click", e => {
                    const id = e.target.dataset.id;
                    const cine = datos.cines.find(c => c.id_cine == id);

                    contDinamico.innerHTML = `
                        <div class="detalle-cine">
                            <h2>${cine.nombre}</h2>
                            <p><strong>Dirección:</strong> ${cine.direccion}</p>
                            <p><strong>Ciudad:</strong> ${cine.ciudad}</p>
                            <p><strong>CP:</strong> ${cine.cp}</p>
                        </div>
                    `;
                });
            });

            document.querySelectorAll(".editar").forEach(el => {
                el.addEventListener("click", e => {
                    const id = e.target.dataset.id;
                    const cine = datos.cines.find(c => c.id_cine == id);

                    contDinamico.innerHTML = `
                        <div class="form-editar-cine">
                            <h2>Editar ${cine.nombre}</h2>
                            <form>
                                <input type="text" name="nombre" value="${cine.nombre}" required>
                                <input type="text" name="direccion" value="${cine.direccion}" required>
                                <input type="text" name="ciudad" value="${cine.ciudad}" required>
                                <input type="text" name="cp" value="${cine.cp}" required>
                                <button type="submit">Guardar</button>
                            </form>
                            <h3>Salas asociadas</h3>
                            <ul>
                                <li>Sala 1</li>
                                <li>Sala 2</li>
                            </ul>
                        </div>
                    `;
                });
            });

            document.getElementById("btn-agregar").addEventListener("click", () => {
                contDinamico.innerHTML = `
                    <div class="form-nuevo-cine">
                        <h2>Agregar nuevo cine</h2>
                        <form>
                            <input type="text" name="nombre" placeholder="Nombre" required>
                            <input type="text" name="direccion" placeholder="Dirección" required>
                            <input type="text" name="ciudad" placeholder="Ciudad" required>
                            <input type="text" name="cp" placeholder="Código Postal" required>
                            <button type="submit">Crear cine</button>
                        </form>
                    </div>
                `;
            });
        } else {
            contenedor.innerHTML = "<p>Error en los datos recibidos.</p>";
        }

    } catch (error) {
        console.error(error);
        contenedor.innerHTML = "<p>Error cargando los cines.</p>";
    }
});

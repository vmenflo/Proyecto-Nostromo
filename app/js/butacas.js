document.addEventListener('DOMContentLoaded', () => {
  const contenedor = document.getElementById('cont-butacas');
  const urlParams = new URLSearchParams(window.location.search);
  const id_cine = urlParams.get("id_cine");
  const id_pelicula = urlParams.get("id_pelicula");
  const fecha = urlParams.get("fecha");
  const hora = urlParams.get("hora");

  const spanCantidad = document.getElementById("cantidad");
  const btnMenos = document.getElementById("menos");
  const btnMas = document.getElementById("mas");
  const PRECIO_ENTRADA = 6;
  const spanPrecio = document.getElementById("p_unitario");
  const spanSubtotal = document.getElementById("p_subtotal");
  const seleccionadas = [];

  function actualizarContador() {
    const cantidad = seleccionadas.length;
    spanCantidad.textContent = cantidad;
    spanPrecio.textContent = `${PRECIO_ENTRADA} €`;
    spanSubtotal.textContent = `${(cantidad * PRECIO_ENTRADA).toFixed(2)} €`;
  }

  actualizarContador();

  fetch(`${API_BASE}/butacas/${id_cine}/${id_pelicula}/${fecha}/${hora}`)
    .then(res => res.ok ? res.json() : Promise.reject(`HTTP ${res.status}`))
    .then(data => {
      if (data.error) {
        contenedor.innerHTML = `<p>Error: ${data.error}</p>`;
        return;
      }

      const id_sala = data.id_sala;
      if (!id_sala) {
        contenedor.innerHTML = `<p>Error: No se pudo obtener la sala</p>`;
        return;
      }

      document.getElementById("fecha").textContent = `Fecha: ${data.fecha}`;
      document.getElementById("sesion").textContent = `Hora: ${data.hora}`;
      document.getElementById("sala").textContent = `Sala ${id_sala}`;

      const filas = data.filas;
      const columnas = data.butacas;
      const ocupadas = data.ocupadas;

      contenedor.style.display = 'grid';
      contenedor.style.gridTemplateColumns = `repeat(${columnas}, auto)`;
      contenedor.style.gap = '5px';

      for (let fila = 1; fila <= filas; fila++) {
        for (let butaca = 1; butaca <= columnas; butaca++) {
          const isOcupada = ocupadas.some(b => b.fila == fila && b.butaca == butaca);

          const svgMarkup = `
          <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 18V21H7V18H17V21H20V15H4V18ZM19 10H22V13H19V10ZM2 10H5V13H2V10ZM17 13H7V5C7 4.47 7.21 3.96 7.59 3.59C7.96 3.21 8.47 3 9 3H15C15.53 3 16.04 3.21 16.41 3.59C16.79 3.96 17 4.47 17 5V13Z" />
          </svg>
        `;

          const template = document.createElement('template');
          template.innerHTML = svgMarkup.trim();
          const svg = template.content.firstChild;

          svg.classList.add("butaca");
          if (isOcupada) svg.classList.add("ocupada");

          svg.dataset.fila = fila;
          svg.dataset.butaca = butaca;

          svg.addEventListener("click", () => {
            if (svg.classList.contains("ocupada")) return;
            svg.classList.toggle("seleccionada");

            const index = seleccionadas.findIndex(b => b[0] === fila && b[1] === butaca);
            if (index >= 0) {
              seleccionadas.splice(index, 1);
            } else {
              seleccionadas.push([fila, butaca]);
            }

            actualizarContador();
          });

          contenedor.appendChild(svg);
        }
      }

      document.querySelector('.boton-cont a').addEventListener('click', (e) => {
        e.preventDefault();

        if (seleccionadas.length === 0) {
          alert("Debes seleccionar al menos un asiento.");
          return;
        }

        const subtotal = (seleccionadas.length * PRECIO_ENTRADA).toFixed(2);
        const butacas = seleccionadas.map(([f, b]) => `F${f}-B${b}`).join(',');

        const params = new URLSearchParams({
          id_pelicula,
          id_cine,
          id_sala,
          fecha,
          hora,
          subtotal,
          butacas
        });

        window.location.href = `/${URL_BASE}/index.php?vista=confirmacion&${params.toString()}`;
      });
    })
    .catch(() => {
      contenedor.innerHTML = `<p>Error al cargar butacas.</p>`;
    });

  btnMenos.addEventListener("click", () => {
    if (seleccionadas.length > 0) {
      const [fila, butaca] = seleccionadas.pop();
      const svg = [...document.querySelectorAll(".butaca.seleccionada")]
        .find(e => e.dataset.fila == fila && e.dataset.butaca == butaca);
      if (svg) svg.classList.remove("seleccionada");
      actualizarContador();
    }
  });

  btnMas.addEventListener("click", () => {
    alert("Selecciona los asientos directamente en el plano.");
  });

  document.querySelector('.boton-volver a').addEventListener('click', (e) => {
    e.preventDefault();
    window.history.back();
  });
});

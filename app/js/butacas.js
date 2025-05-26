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

  actualizarContador()


  fetch(`/Proyecto-Nostromo/servicios_rest/butacas/${id_cine}/${id_pelicula}/${fecha}/${hora}`)
    .then(res => {
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      return res.json();
    })
    .then(data => {
      if (data.error) {
        contenedor.innerHTML = `<p>Error: ${data.error}</p>`;
        return;
      }

      // PINTAR fecha, hora y sala
      document.getElementById("fecha").textContent = `Fecha: ${data.fecha}`;
      document.getElementById("sesion").textContent = `Hora: ${data.hora}`;
      document.getElementById("sala").textContent = `Sala ${data.sala}`;


      const filas = data.filas;
      const columnas = data.butacas;
      const ocupadas = data.ocupadas;

      contenedor.style.display = 'grid';
      contenedor.style.gridTemplateColumns = `repeat(${columnas}, auto)`;
      contenedor.style.gap = '5px';
      contenedor.style.justifyContent = 'center';
      contenedor.style.padding = '20px';

      for (let fila = 1; fila <= filas; fila++) {
        for (let butaca = 1; butaca <= columnas; butaca++) {
          const isOcupada = ocupadas.some(b => b.fila == fila && b.butaca == butaca);

          const svgMarkup = `
            <svg width="24" height="24" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M4 18V21H7V18H17V21H20V15H4V18ZM19 10H22V13H19V10ZM2 10H5V13H2V10ZM17 13H7V5C7 4.46957 7.21071 3.96086 7.58579 3.58579C7.96086 3.21071 8.46957 3 9 3H15C15.5304 3 16.0391 3.21071 16.4142 3.58579C16.7893 3.96086 17 4.46957 17 5V13Z" />
            </svg>
          `;

          const template = document.createElement('template');
          template.innerHTML = svgMarkup.trim();
          const svg = template.content.firstChild;

          svg.classList.add("butaca");
          if (isOcupada) svg.classList.add("ocupada");

          svg.dataset.fila = fila;
          svg.dataset.butaca = butaca;
          svg.setAttribute("title", `Fila ${fila}, Butaca ${butaca}`);

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
    })
    .catch(err => {
      contenedor.innerHTML = `<p>Error al cargar butacas.</p>`;
      console.error(err);
    });

  btnMas.addEventListener("click", () => {
    alert("Selecciona los asientos directamente en el plano para añadir.");
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
  /* Volver */
  document.querySelector('.boton-volver a').addEventListener('click', (e) => {
    e.preventDefault();
    window.history.back();
  });

  /* Continuar */
  document.querySelector('.boton-cont a').addEventListener('click', (e) => {
    e.preventDefault();

    if (seleccionadas.length === 0) {
      alert("Debes seleccionar al menos un asiento.");
      return;
    }

    const titulo = document.querySelector('.titulo-pelicula')?.textContent || '';
    const salaTexto = document.getElementById('sala')?.textContent || '';
    const sala = salaTexto.replace("Sala:", "").trim();
    const subtotal = (seleccionadas.length * PRECIO_ENTRADA).toFixed(2);
    const butacas = seleccionadas.map(([f, b]) => `F${f}-B${b}`).join(',');

    const params = new URLSearchParams({
      titulo,
      sala,
      fecha,
      hora,
      subtotal,
      butacas
    });

    // Ajusta el destino a tu vista de confirmación
    window.location.href = `/Proyecto-Nostromo/app/index.php?vista=confirmacion&${params.toString()}`;
  });

});

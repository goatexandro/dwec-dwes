let elementos = [];

window.onload = async () => {
  try {
    const response = await fetch(
      "http://localhost/dwec-dwes/Trabajo/ws/getElement.php"
    );
    const result = await response.json();

    if (result.success) {
      elementos = result.data;
      tabla(elementos);
    } else {
      Swal.fire("Error", "No se pudieron cargar los elementos.", "error");
    }
  } catch (error) {
    Swal.fire("Error", "Hubo un problema con la conexión.", "error");
  }
};

const formulario = document.getElementById("formulario");

formulario.addEventListener("submit", async function (event) {
  event.preventDefault();

  const formData = new FormData(event.target);

  try {
    const confirm = await Swal.fire({
      title: "¿Estás seguro?",
      text: "¿Deseas crear este elemento?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, enviar",
      cancelButtonText: "Cancelar",
    });

    if (confirm.isConfirmed) {
      const response = await fetch("ws/createElement2.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        Swal.fire("¡Éxito!", result.message, "success");
        formulario.reset();
      } else {
        Swal.fire("Error", result.message, "error");
      }
    }
  } catch (error) {
    Swal.fire("Error", "Hubo un problema con la solicitud", "error");
  }
});

const tabla = (elementos) => {
  const tableBody = document.getElementById("tablaBody");
  tableBody.innerHTML = "";

  elementos.forEach((elemento, index) => {
    const row = document.createElement("tr");
    row.innerHTML = `
            <td>${elemento.nombre}</td>
            <td>${elemento.descripcion}</td>
            <td>${elemento.numeroSerie}</td>
            <td>${elemento.estado}</td>
            <td>${elemento.prioridad}</td>
            <td>
                <button onclick="editar(${index})">Editar</button>
                <button onclick="eliminar(${index})">X</button>
            </td>
        `;
    tableBody.appendChild(row);
  });
};
const editar = (filaIndex) => {
  const elemento = elementos[filaIndex];

  document.getElementById("nombre").value = elemento.nombre;
  document.getElementById("descripcion").value = elemento.descripcion;
  document.getElementById("numeroSerie").value = elemento.numeroSerie;

  const estados = document.getElementsByName("estado");
  estados.forEach((c) => {
    if (c.value === elemento.estado) {
      c.checked = true;
    }
  });

  const prioridads = document.getElementsByName("prioridad");
  prioridads.forEach((c) => {
    if (c.value === elemento.prioridad) {
      c.checked = true;
    }
  });

  document.getElementById("formulario").style.display = "block";
  document.getElementById("indexElemento").value = filaIndex;

  document.getElementById("edit").onsubmit = function (event) {
    event.preventDefault();
    guardar(filaIndex);
  };

  document.getElementById("cancelarBtn").onclick = cancelar;

  document.getElementById("nombre").value = elemento.nombre;
  document.getElementById("descripcion").value = elemento.descripcion;
  document.getElementById("numeroSerie").value = elemento.numeroSerie;

  document.querySelector(
    `input[name="estado"][value="${elemento.estado}"]`
  ).checked = true;

  document.querySelector(
    `input[name="prioridad"][value="${elemento.prioridad}"]`
  ).checked = true;

  document.getElementById("formulario").style.display = "block";

  document.getElementById("indexElemento").value = index;
};
const guardar = async (filaIndex) => {
  const nombre = document.getElementById("nombre").value;
  const descripcion = document.getElementById("descripcion").value;
  const numeroSerie = document.getElementById("numeroSerie").value;
  const estado = document.querySelector('input[name="estado"]:checked').value;
  const prioridad = document.querySelector(
    'input[name="prioridad"]:checked'
  ).value;

  const confirmacion = await Swal.fire({
    title: "¿Estás seguro?",
    text: "¿Deseas guardar los cambios?",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Sí, guardar",
    cancelButtonText: "Cancelar",
  });

  if (confirmacion.isConfirmed) {
    try {
      const response = await fetch(
        "http://localhost/dwec-dwes/Trabajo/ws/modifyElement.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id: elementos[filaIndex].id,
            nombre,
            descripcion,
            numeroSerie,
            estado,
            prioridad,
          }),
        }
      );

      const result = await response.json();

      if (result.success) {
        Swal.fire("Guardado", "Elemento editado con éxito.", "success");
        tabla(elementos);
        document.getElementById("formulario").style.display = "none";
      } else {
        Swal.fire("Error", result.message || "No se pudo editar.", "error");
      }
    } catch {}
  } else {
    console.log("El usuario canceló la acción de guardar.");
  }
};

const cancelar = () => {
  document.getElementById("formulario").style.display = "none";
};

const eliminar = async (index) => {
  const confirmacion = await Swal.fire({
    title: "¿Estás seguro?",
    text: "¿Deseas eliminar este elemento?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí",
    cancelButtonText: "Cancelar",
  });

  if (confirmacion.isConfirmed) {
    try {
      const response = await fetch(
        "http://localhost/dwec-dwes/Trabajo/ws/deleteElement.php",
        {
          method: "POST",
          body: JSON.stringify({ id: elementos[index].id }),
        }
      );

      const result = await response.json();

      if (result.success) {
        Swal.fire("Eliminado", "Elemento eliminado con éxito.", "success");

        elementos.splice(index, 1);

        tabla(elementos);
      } else {
        Swal.fire("Error", result.message || "No se pudo eliminar.", "error");
      }
    } catch (error) {}
  } else {
    console.log("El usuario canceló la acción de eliminar.");
  }
};

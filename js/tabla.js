const elementos = [
    { nombre: "fluor", descripcion: "Es muy peligroso", numeroSerie: "43253", estado: "Activo", prioridad: "Alta" },
    { nombre: "XCSA", descripcion: "Se utiliza para las rataso", numeroSerie: "55555", estado: "Inactivo", prioridad: "Media" },
    { nombre: "MANJA", descripcion: "Es la mezcla de 5 elementos distintos", numeroSerie: "77777", estado: "Activo", prioridad: "Baja" }
];

window.onload = () => {
    tabla(elementos);

    const input = document.getElementById("filtro");
    input.addEventListener("input", () => {
        const cantidad = input.value.trim().toLowerCase();
        if (cantidad.length >= 3) {
            busqueda(cantidad);
        } else {
            tabla(elementos);
        }
    });
    const busqueda = (iniciodepalabra) => {
        const elementosFiltrados = elementos.filter(elemento => 
            elemento.nombre.toLowerCase().includes(iniciodepalabra) ||
            elemento.descripcion.toLowerCase().includes(iniciodepalabra)
        );
    
        tabla(elementosFiltrados);
    }
};

const tabla = (tabla) => {
    const tablainfo = document.getElementById("elemento").getElementsByTagName("tbody")[0];

    if (!tablainfo) {
        const nuevoCuerpo = document.createElement("tbody");
        document.getElementById("elemento").appendChild(nuevoCuerpo);
    } else {
        tablainfo.innerHTML = "";
    }

    for (let i = 0; i < tabla.length; i++) {
        const elemento = tabla[i];
        const fila = document.createElement("tr");

        const nombre = document.createElement("td");
        nombre.textContent = elemento.nombre;

        const descripcion = document.createElement("td");
        descripcion.textContent = elemento.descripcion;

        const numeroSerie = document.createElement("td");
        numeroSerie.textContent = elemento.numeroSerie;

        const estado = document.createElement("td");
        estado.textContent = elemento.estado;

        const prioridad = document.createElement("td");
        prioridad.textContent = elemento.prioridad;

        const acciones = document.createElement("td");
        const botonx = document.createElement("button");
        botonx.textContent = "X";
        botonx.classList.add("eliminar");
        botonx.setAttribute("data-index", i); 
        acciones.appendChild(botonx);

        fila.appendChild(nombre);
        fila.appendChild(descripcion);
        fila.appendChild(numeroSerie);
        fila.appendChild(estado);
        fila.appendChild(prioridad);
        fila.appendChild(acciones);

        document.querySelector("#elemento tbody").appendChild(fila);
    }

    const botonesquitar = document.querySelectorAll(".eliminar");
    for (let i = 0; i < botonesquitar.length; i++) {
        botonesquitar[i].onclick = () => {
            const filaIndex = botonesquitar[i].getAttribute("data-index");
            quitar(filaIndex);
        };
    }
}

const quitar = (filaIndex) => {
    const tbody = document.querySelector("#elemento tbody");
    tbody.deleteRow(filaIndex);
}


let id = null;
let editando = false;

let filaCategoriaActiva = null;
let filaMedicamentoActiva = null;
let filaLoteActiva = null;

let categoriaSeleccionada = null;
let medicamentoSeleccionado = null;

document.addEventListener('DOMContentLoaded', () => {
    cargarDatos('categorias');
    initDeseleccionarTablas();

    document.getElementById('btnAbrirCategoria').addEventListener('click', () => {
        editando = false;
        document.getElementById('formCategoria').reset();
        document.getElementById('modalCategoria').style.display = 'flex';
    });
    
    document.getElementById('btnAbrirMedicamento').addEventListener('click', () => {
        if (!categoriaSeleccionada) {
            alert('Seleccione una categoría primero');
            return;
        }
        editando = false;
        document.getElementById('formMedicamento').reset();
        document.getElementById('modalMedicamento').style.display = 'flex';
    });
    
    document.getElementById('btnAbrirLote').addEventListener('click', () => {
        if (!medicamentoSeleccionado) {
            alert('Seleccione un medicamento primero');
            return;
        }
        editando = false;
        document.getElementById('formLote').reset();
        document.getElementById('modalLote').style.display = 'flex';
    });

    // --- BOTONES EDITAR ---
    document.getElementById('btnEditarCategoria').addEventListener('click', () => {
        if (!filaCategoriaActiva) {
            alert('Seleccione una categoría de la tabla para editar');
            return;
        }
        editando = true;
        id = filaCategoriaActiva.dataset.id; 
        
        const nombreActual = filaCategoriaActiva.cells[0].innerText;
        document.getElementsByName('nombre_categoria')[0].value = nombreActual;
        
        document.getElementById('modalCategoria').style.display = 'flex';
    });

    document.getElementById('btnEditarMedicamento').addEventListener('click', () => {
        if (!filaMedicamentoActiva) {
            alert('Seleccione un medicamento de la tabla para editar');
            return;
        }
        editando = true;
        id = filaMedicamentoActiva.dataset.id; 

        document.getElementsByName('codigo')[0].value = filaMedicamentoActiva.cells[0].innerText;
        document.getElementsByName('nombre_comercial')[0].value = filaMedicamentoActiva.cells[1].innerText;
        document.getElementsByName('forma')[0].value = filaMedicamentoActiva.cells[2].innerText;
        document.getElementsByName('concentracion')[0].value = filaMedicamentoActiva.cells[3].innerText;
        document.getElementsByName('receta')[0].value = filaMedicamentoActiva.cells[4].innerText;

        document.getElementById('modalMedicamento').style.display = 'flex';
    });

    document.getElementById('btnEditarLote').addEventListener('click', () => {
        if (!filaLoteActiva) {
            alert('Seleccione un lote de la tabla para editar');
            return;
        }
        editando = true;
        id = filaLoteActiva.dataset.id; 

        document.getElementsByName('numero_lote')[0].value = filaLoteActiva.cells[0].innerText;
        document.getElementsByName('ingreso')[0].value = filaLoteActiva.cells[1].innerText;
        document.getElementsByName('caducidad')[0].value = filaLoteActiva.cells[2].innerText;
        document.getElementsByName('stock')[0].value = filaLoteActiva.cells[3].innerText;
        document.getElementsByName('ubicacion')[0].value = filaLoteActiva.cells[4].innerText;
        document.getElementsByName('precio_compra')[0].value = filaLoteActiva.cells[5].innerText;
        document.getElementsByName('precio_venta')[0].value = filaLoteActiva.cells[6].innerText;
        document.getElementsByName('estado')[0].value = filaLoteActiva.cells[7].innerText;

        document.getElementById('modalLote').style.display = 'flex';
    });

    document.getElementById('cerrarCategoria').addEventListener('click', () => {
        document.getElementById('modalCategoria').style.display = 'none';
    });
    document.getElementById('cerrarMedicamento').addEventListener('click', () => {
        document.getElementById('modalMedicamento').style.display = 'none';
    });
    document.getElementById('cerrarLote').addEventListener('click', () => {
        document.getElementById('modalLote').style.display = 'none';
    });
});

function cargarDatos(v) {
    const fd = new FormData();
    fd.append('datos', v);
    
    if (v === 'medicamentos' && categoriaSeleccionada) {
        fd.append('id_categoria', categoriaSeleccionada);
    }
    if (v === 'lotes' && medicamentoSeleccionado) {
        fd.append('id_medicamento', medicamentoSeleccionado);
    }

    fetch('cargar_datos.php', {
        method: 'POST',
        body: fd
    })
    .then(response => response.json())
    .then(data => {
        if (v === 'categorias') {
            viewCategorias(data);
        }
        if (v === 'medicamentos') {
            viewMedicamentos(data);
        }
        if (v === 'lotes') {
            viewLotes(data);
        }
    })
    .catch(error => console.error(error));
}

function viewCategorias(data) {
    const tbody = document.getElementById('tablaCategorias');
    tbody.innerHTML = '';
    
    data.forEach((dato, index) => {
        const row = document.createElement('tr');
        row.dataset.id = dato.id_categoria;
        
        let numeroItems = 1;

        row.innerHTML = `
            <td>${dato.nombre_categoria}</td>
            <td>${numeroItems}</td>
        `;
        
        row.addEventListener('click', (e) => {
            e.stopPropagation();
            seleccionarCategoriaFila(row, dato.id_categoria);
        });
        
        tbody.appendChild(row);

        if (index === 0) {
            seleccionarCategoriaFila(row, dato.id_categoria);
        }
    });
}

function seleccionarCategoriaFila(row, idCategoria) {
    document.querySelectorAll('#tablaCategorias tr').forEach(fila => fila.classList.remove('seleccionado'));
    row.classList.add('seleccionado');
    
    categoriaSeleccionada = idCategoria;
    filaCategoriaActiva = row; 

    medicamentoSeleccionado = null; 
    filaMedicamentoActiva = null;
    filaLoteActiva = null;
    document.getElementById('tablaLotes').innerHTML = ''; 
    
    cargarDatos('medicamentos');
}

function viewMedicamentos(data) {
    const tbody = document.getElementById('tablaMedicamentos');
    tbody.innerHTML = '';
    
    data.forEach(medicamento => {
        const row = document.createElement('tr');
        row.dataset.id = medicamento.codigo;
        row.innerHTML = `
            <td>${medicamento.codigo}</td>
            <td>${medicamento.nombre_comercial}</td>
            <td>${medicamento.forma}</td>
            <td>${medicamento.concentracion}</td>
            <td>${medicamento.receta}</td>
        `;
        
        row.addEventListener('click', (e) => {
            e.stopPropagation();
            document.querySelectorAll('#tablaMedicamentos tr').forEach(fila => fila.classList.remove('seleccionado'));
            row.classList.add('seleccionado');
            
            medicamentoSeleccionado = medicamento.codigo;
            filaMedicamentoActiva = row; 
            filaLoteActiva = null; 
            
            cargarDatos('lotes');
        });
        
        tbody.appendChild(row);
    });
}

function viewLotes(data) {
    const tbody = document.getElementById('tablaLotes');
    tbody.innerHTML = '';
    data.forEach(lote => {
        const row = document.createElement('tr');
        row.dataset.id = lote.id_lote;
        row.innerHTML = `
            <td>${lote.numero_lote}</td>
            <td>${lote.ingreso}</td>
            <td>${lote.caducidad}</td>
            <td>${lote.stock}</td>
            <td>${lote.ubicacion}</td>
            <td>${lote.precio_compra}</td>
            <td>${lote.precio_venta}</td>
            <td>${lote.estado}</td>
        `;
        row.addEventListener('click', (e) => {
            e.stopPropagation();
            document.querySelectorAll('#tablaLotes tr').forEach(fila => fila.classList.remove('seleccionado'));
            row.classList.add('seleccionado');
            
            filaLoteActiva = row; 
        });
        tbody.appendChild(row);
    });
}

document.getElementById('formCategoria').addEventListener('submit', function(e){
    e.preventDefault();
    const fd = new FormData(this);
    
    if (editando) {
        fd.append('accion', 'editar_categoria');
        fd.append('id_categoria', id);
    } else {
        fd.append('accion', 'agregar_categoria');
    }

    fetch('botones.php',{
        method:'POST',
        body:fd
    })
    .then(response => response.text())
    .then(() => {
        cargarDatos('categorias');
        document.getElementById('modalCategoria').style.display = 'none';
        this.reset();
    });
});

document.getElementById('formMedicamento').addEventListener('submit', function(e){
    e.preventDefault();
    if(!categoriaSeleccionada){
        alert('Seleccione una categoría');
        return;
    }
    const fd = new FormData(this);
    fd.append('id_categoria', categoriaSeleccionada);
    
    if (editando) {
        fd.append('accion', 'editar_medicamento');
        fd.append('id_original', id); 
    } else {
        fd.append('accion', 'agregar_medicamento');
    }

    fetch('botones.php',{
        method:'POST',
        body:fd
    })
    .then(response => response.text())
    .then(() => {
        cargarDatos('medicamentos');
        document.getElementById('modalMedicamento').style.display = 'none';
        this.reset();
    });
});

document.getElementById('formLote').addEventListener('submit', function(e){
    e.preventDefault();
    if(!medicamentoSeleccionado){
        alert('Seleccione un medicamento');
        return;
    }
    const fd = new FormData(this);
    fd.append('codigo_medicamento', medicamentoSeleccionado); 
    
    if (editando) {
        fd.append('accion', 'editar_lote');
        fd.append('id_lote', id);
    } else {
        fd.append('accion', 'agregar_lote');
    }

    fetch('botones.php',{
        method:'POST',
        body:fd
    })
    .then(response => response.text())
    .then(() => {
        cargarDatos('lotes');
        document.getElementById('modalLote').style.display = 'none';
        this.reset();
    });
});

document.getElementById('btnEliminarCategoria').addEventListener('click', () => {
    if(!filaCategoriaActiva){
        alert('Seleccione una categoría');
        return;
    }
    if(!confirm('¿Está seguro de eliminar esta categoría?')){
        return;
    }
    const fd = new FormData();
    fd.append('accion','eliminar_categoria');
    fd.append('id',filaCategoriaActiva.dataset.id);
    fetch('botones.php',{
        method:'POST',
        body:fd
    })
    .then(response => response.text())
    .then(() => {
        cargarDatos('categorias');
        filaCategoriaActiva = null;
        categoriaSeleccionada = null;
    });
});

document.getElementById('btnEliminarMedicamento').addEventListener('click', () => {
    if(!filaMedicamentoActiva){
        alert('Seleccione un medicamento');
        return;
    }
    if(!confirm('¿Está seguro de eliminar este medicamento?')){
        return;
    }
    const fd = new FormData();
    fd.append('accion','eliminar_medicamento');
    fd.append('codigo',filaMedicamentoActiva.dataset.id);
    fetch('botones.php',{
        method:'POST',
        body:fd
    })
    .then(response => response.text())
    .then(() => {
        cargarDatos('medicamentos');
        filaMedicamentoActiva = null;
    });
});

document.getElementById('btnEliminarLote').addEventListener('click', () => {
    if(!filaLoteActiva){
        alert('Seleccione un lote');
        return;
    }
    if(!confirm('¿Está seguro de eliminar este lote?')){
        return;
    }
    const fd = new FormData();
    fd.append('accion','eliminar_lote');
    fd.append('id',filaLoteActiva.dataset.id);
    fetch('botones.php',{
        method:'POST',
        body:fd
    })
    .then(response => response.text())
    .then(() => {
        cargarDatos('lotes');
        filaLoteActiva = null;
    });
});

function initDeseleccionarTablas() {
    const thCategorias = document.querySelector('#tablaCategorias').closest('table').querySelector('thead');
    if (thCategorias) {
        thCategorias.addEventListener('click', () => {
            document.querySelectorAll('#tablaCategorias tr').forEach(fila => fila.classList.remove('seleccionado'));
            categoriaSeleccionada = null;
            medicamentoSeleccionado = null;
            filaCategoriaActiva = null;
            filaMedicamentoActiva = null;
            filaLoteActiva = null;
            document.getElementById('tablaMedicamentos').innerHTML = '';
            document.getElementById('tablaLotes').innerHTML = '';
        });
    }
    const thMedicamentos = document.querySelector('#tablaMedicamentos').closest('table').querySelector('thead');
    if (thMedicamentos) {
        thMedicamentos.addEventListener('click', () => {
            document.querySelectorAll('#tablaMedicamentos tr').forEach(fila => fila.classList.remove('seleccionado'));
            medicamentoSeleccionado = null;
            filaMedicamentoActiva = null;
            filaLoteActiva = null;
            document.getElementById('tablaLotes').innerHTML = '';
        });
    }
    const thLotes = document.querySelector('#tablaLotes').closest('table').querySelector('thead');
    if (thLotes) {
        thLotes.addEventListener('click', () => {
            document.querySelectorAll('#tablaLotes tr').forEach(fila => fila.classList.remove('seleccionado'));
            filaLoteActiva = null;
        });
    }
}

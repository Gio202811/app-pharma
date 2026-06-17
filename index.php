<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Farmacéutico</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header class="header">
    <h3>Almacén ></h3>
    <h1>Inventario General</h1>
</header>
<main class="container">
<section class="grid">
    <article class="card span-2">
        <h4>STOCK TOTAL</h4>
        <h1>12,482</h1>
        <p>+5.2% este mes</p>
    </article>
    <article class="card span-2">
        <h4>VENCIMIENTOS (30D)</h4>
        <h1>142</h1>
        <p>Acción Requerida</p>
    </article>
    <article class="card span-2">
        <h4>NUEVOS INGRESOS</h4>
        <h1>28</h1>
        <p>Últimas 24 horas</p>
    </article>
    <article class="card span-2 activo">
        <h4>ESTADO DE PEDIDOS</h4>
        <h1>Activo</h1>
        <p>92% eficiencia logística</p>
    </article>
    
    <article class="card span-5">
        <div class="titulo">
            <h2>Medicamentos</h2>
            <div class="acciones">
                <button class="btn-agregar" id="btnAbrirMedicamento">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <button class="btn-editar" id="btnEditarMedicamento">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="btn-eliminar" id="btnEliminarMedicamento">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Código Único</th>
                    <th>Nombre Comercial</th>
                    <th>Forma</th>
                    <th>Conc.</th>
                    <th>Receta</th>
                </tr>
            </thead>
            <tbody id="tablaMedicamentos"></tbody>
        </table>
    </article>
    
    <article class="card span-3">
        <div class="titulo">
            <h2>Categorías</h2>
            <div class="acciones">
                <button class="btn-agregar" id="btnAbrirCategoria">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <button class="btn-editar" id="btnEditarCategoria">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="btn-eliminar" id="btnEliminarCategoria">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nombre Categoría</th>
                    <th>Items</th>
                </tr>
            </thead>
            <tbody id="tablaCategorias"></tbody>
        </table>
    </article> 
    
    <article class="card span-full">
        <div class="titulo">
            <h2>Trazabilidad de Lotes</h2>
            <div class="acciones">
                <button class="btn-lote" id="btnAbrirLote">
                    <i class="fa-solid fa-plus"></i>
                    Agregar Lote
                </button>
                <button class="btn-lote" id="btnEditarLote">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Editar
                </button>
                <button class="btn-lote" id="btnEliminarLote">
                    <i class="fa-solid fa-trash"></i>
                    Eliminar
                </button>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>N° Lote</th>
                    <th>Ingreso</th>
                    <th>Caducidad</th>
                    <th>Stock</th>
                    <th>Ubicación</th>
                    <th>P. Compra</th>
                    <th>P. Venta</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="tablaLotes"></tbody>
        </table>
    </article>
</section>
</main>

    <div id="modalCategoria" class="modal" style="display:none;">
        <div class="modal-content">
            <h2>Nueva Categoría</h2>
            <form id="formCategoria">
                <div class="form-group">
                    <label>Nombre Categoría</label>
                    <input type="text" name="nombre_categoria" required>
                </div>
                <div class="form-botones">
                    <button type="submit" class="btn-guardar-lote">Guardar</button>
                    <button type="button" id="cerrarCategoria" class="btn-cancelar-lote">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalMedicamento" class="modal" style="display:none;">
        <div class="modal-content">
            <h2>Nuevo Medicamento</h2>
            <form id="formMedicamento">
                <div class="form-group">
                    <label>Código</label>
                    <input type="text" name="codigo" required>
                </div>
                <div class="form-group">
                    <label>Nombre Comercial</label>
                    <input type="text" name="nombre_comercial" required>
                </div>
                <div class="form-group">
                    <label>Forma</label>
                    <input type="text" name="forma" required>
                </div>
                <div class="form-group">
                    <label>Concentración</label>
                    <input type="text" name="concentracion" required>
                </div>
                <div class="form-group">
                    <label>Receta</label>
                    <select name="receta" required>
                        <option value="">Seleccione</option>
                        <option value="REQUERIDA">REQUERIDA</option>
                        <option value="VENTA LIBRE">VENTA LIBRE</option>
                    </select>
                </div>
                <div class="form-botones">
                    <button type="submit" class="btn-guardar-lote">Guardar</button>
                    <button type="button" id="cerrarMedicamento" class="btn-cancelar-lote">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalLote" class="modal" style="display:none;">
        <div class="modal-content">
            <h2>Lotes</h2>
            <form id="formLote">
                <div class="form-group">
                    <label>Número de lote:</label>
                    <input type="text" name="numero_lote" required>
                </div>
                <div class="fila-2">
                    <div class="form-group">
                        <label>Fecha de ingreso:</label>
                        <input type="date" name="ingreso" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha caducidad:</label>
                        <input type="date" name="caducidad" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Existencias:</label>
                    <input type="number" name="stock" required>
                </div>
                <div class="form-group">
                    <label>Ubicación:</label>
                    <input type="text" name="ubicacion" required>
                </div>
                <div class="form-group">
                    <label>Código medicamento:</label>
                    <input type="text" name="codigo_medicamento" required>
                </div>
                <div class="form-group">
                    <label>Estado:</label>
                    <select name="estado" required>
                        <option value="">Seleccione</option>
                        <option value="ÓPTIMO">ÓPTIMO</option>
                        <option value="ESTABLE">ESTABLE</option>
                        <option value="CRÍTICO">CRÍTICO</option>
                    </select>
                </div>
                <div class="fila-2">
                    <div class="form-group">
                        <label>Precio de compra:</label>
                        <input type="number" step="0.01" name="precio_compra" required>
                    </div>
                    <div class="form-group">
                        <label>Precio de venta:</label>
                        <input type="number" step="0.01" name="precio_venta" required>
                    </div>
                </div>
                <div class="form-botones">
                    <button type="submit" class="btn-guardar-lote">Guardar</button>
                    <button type="button" id="cerrarLote" class="btn-cancelar-lote">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

<script src="js/app.js"></script>
</body>
</html>
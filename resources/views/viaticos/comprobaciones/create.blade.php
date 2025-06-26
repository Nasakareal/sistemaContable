@extends('adminlte::page')

@section('title', 'Registrar Comprobaciones')

@section('content_header')
    <h1>Registrar Comprobaciones para Viático #{{ $viatico->id }}</h1>
@stop

@section('css')
    <style>
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        /* Fondo oscuro para toda la tabla y elementos relacionados */
        table.dataTable,
        .table,
        .table-bordered,
        .table-striped,
        .table-hover {
            background-color: #1f2937 !important;
            color: white !important;
        }

        table.dataTable thead {
            background-color: #374151 !important;
            color: white !important;
        }

        table.dataTable tbody tr:nth-child(even) {
            background-color: #111827 !important;
        }

        table.dataTable td,
        table.dataTable th {
            border-color: #4b5563 !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: white !important;
        }

        select.form-control,
        input.form-control,
        .form-select {
            background-color: #1f2937 !important;
            color: white !important;
            border: 1px solid #4b5563;
        }

        .btn-primary {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }

        .btn {
            color: white !important;
        }

        /* Arreglar fondo de tarjetas */
        .card {
            background-color: #1f2937 !important;
            color: white;
        }

        .card-header {
            background-color: #374151 !important;
            color: white;
        }

        /* Botones de exportar DataTables */
        .dataTables_wrapper .dt-buttons .btn {
            background-color: #2563eb !important;
            color: white !important;
            border: none;
        }

        /* MENÚ de Opciones (dropdown de botones DataTables) */
        .dt-button-collection {
            background-color: #1f2937 !important;
            color: white !important;
            border: 1px solid #4b5563 !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .dt-button-collection .dt-button {
            background-color: #374151 !important;
            color: white !important;
            border: none;
        }

        .dt-button-collection .dt-button:hover {
            background-color: #2563eb !important;
            color: white !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@stop

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title">Llene los Datos de la Comprobación</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('comprobaciones.store', $viatico->id) }}" method="POST">
          @csrf

          <div id="comprobaciones-container">
            {{-- Item inicial con índice 0 --}}
            <div class="comprobacion-item mb-4" data-index="0">
              <div class="row">
                <div class="col-md-3">
                  <label>Cuenta Contable</label>
                  <input type="text"
                         name="comprobaciones[0][cuenta_contable]"
                         class="form-control"
                         value="{{ $cuentaContable }}"
                         readonly>
                </div>
                <div class="col-md-3">
                  <label>Capítulo</label>
                  <select name="comprobaciones[0][capitulo_id]"
                          id="capitulo_id_0"
                          class="form-control capitulo-select"
                          required>
                    <option value="">Seleccione un capítulo</option>
                    @foreach($capitulos as $cap)
                      <option value="{{ $cap->id }}">{{ $cap->nombre }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <label>Partida</label>
                  <select name="comprobaciones[0][partidas][0][id]"
                          id="partida_0_0"
                          class="form-control partida-select"
                          required>
                    <option value="">Seleccione una partida</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label>Monto Partida</label>
                  <input type="number"
                         step="0.01"
                         name="comprobaciones[0][partidas][0][monto]"
                         class="form-control"
                         required>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-3">
                  <label>Tipo</label>
                  <select name="comprobaciones[0][tipo]"
                          class="form-control"
                          required>
                    <option value="">Seleccione</option>
                    <option value="GASTO">GASTO</option>
                    <option value="REINTEGRO">REINTEGRO</option>
                    <option value="ADICIONAL">ADICIONAL</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <button type="button" class="btn btn-info" id="add-comprobacion">
              <i class="fas fa-plus"></i> Agregar otra comprobación
            </button>
          </div>

          <hr>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-check"></i> Guardar Comprobaciones
            </button>
            <a href="{{ route('comprobaciones.index', $viatico->id) }}" class="btn btn-secondary">
              <i class="fas fa-ban"></i> Cancelar
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@stop

@section('js')
<script>
  @if ($errors->any())
    Swal.fire({
      icon: 'error',
      title: 'Errores en el formulario',
      html: `<ul style="text-align: left;">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>`,
      confirmButtonText: 'Aceptar'
    });
  @endif
</script>

<script>
  const cuentaContable = @json($cuentaContable);
  const capitulos      = @json($capitulos->map(fn($c) => ['id' => $c->id, 'nombre' => $c->nombre]));
  let index = 1;

  function createComprobacionItem(idx) {
    return `
      <div class="comprobacion-item mb-4" data-index="${idx}">
        <div class="row">
          <div class="col-md-3">
            <label>Cuenta Contable</label>
            <input type="text"
                   name="comprobaciones[${idx}][cuenta_contable]"
                   class="form-control"
                   value="${cuentaContable}"
                   readonly>
          </div>
          <div class="col-md-3">
            <label>Capítulo</label>
            <select name="comprobaciones[${idx}][capitulo_id]"
                    id="capitulo_id_${idx}"
                    class="form-control capitulo-select"
                    required>
              <option value="">Seleccione un capítulo</option>
              ${capitulos.map(c => `<option value="${c.id}">${c.nombre}</option>`).join('')}
            </select>
          </div>
          <div class="col-md-3">
            <label>Partida</label>
            <select name="comprobaciones[${idx}][partidas][0][id]"
                    id="partida_${idx}_0"
                    class="form-control partida-select"
                    required>
              <option value="">Seleccione una partida</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Monto Partida</label>
            <input type="number"
                   step="0.01"
                   name="comprobaciones[${idx}][partidas][0][monto]"
                   class="form-control"
                   required>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-md-3">
            <label>Tipo</label>
            <select name="comprobaciones[${idx}][tipo]"
                    class="form-control"
                    required>
              <option value="">Seleccione</option>
              <option value="GASTO">GASTO</option>
              <option value="REINTEGRO">REINTEGRO</option>
              <option value="ADICIONAL">ADICIONAL</option>
            </select>
          </div>
        </div>
      </div>`;
  }

  function attachCapituloListener(idx) {
    const cap = document.getElementById(`capitulo_id_${idx}`);
    const part = document.getElementById(`partida_${idx}_0`);
    cap.addEventListener('change', () => {
      part.innerHTML = '<option>Cargando...</option>';
      fetch(`{{ url('/partidas/capitulo') }}/${cap.value}`)
        .then(r => r.json())
        .then(data => {
          part.innerHTML = '<option value="">Seleccione una partida</option>';
          data.forEach(p => {
            const o = document.createElement('option');
            o.value = p.id;
            o.textContent = `${p.nombre} - ${p.descripcion}`;
            part.appendChild(o);
          });
        });
    });
  }

  document.getElementById('add-comprobacion').addEventListener('click', () => {
    const container = document.getElementById('comprobaciones-container');
    container.insertAdjacentHTML('beforeend', createComprobacionItem(index));
    attachCapituloListener(index);
    index++;
  });

  // Listener inicial para el primer bloque
  attachCapituloListener(0);
</script>
@stop


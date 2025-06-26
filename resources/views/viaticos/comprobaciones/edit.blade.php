@extends('adminlte::page')

@section('title', 'Editar Comprobación')

@section('content_header')
    <h1>Editar Comprobación del Viático #{{ $viatico->id }}</h1>
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
    <div class="card card-outline card-success">
      <div class="card-header">
        <h3 class="card-title">Modifique los Datos de la Comprobación</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('comprobaciones.update', [$viatico->id, $comprobacion->id]) }}" method="POST">
          @csrf
          @method('PUT')

          <div id="comprobaciones-container">
            {{-- Item inicial con índice 0 --}}
            <div class="comprobacion-item mb-4" data-index="0">
              <div class="row">
                {{-- Cuenta Contable --}}
                <div class="col-md-3">
                  <label>Cuenta Contable</label>
                  <input type="text"
                         name="cuenta_contable"
                         class="form-control"
                         value="{{ $comprobacion->cuenta_contable }}"
                         readonly>
                </div>

                {{-- Capítulo --}}
                <div class="col-md-3">
                  <label>Capítulo</label>
                  <select name="partidas[0][capitulo_id]"
                          id="capitulo_id_0"
                          class="form-control capitulo-select"
                          required>
                    <option value="">Seleccione un capítulo</option>
                    @foreach($capitulos as $cap)
                      <option value="{{ $cap->id }}"
                        {{ $comprobacion->partidas->first()->capitulo_id == $cap->id ? 'selected' : '' }}>
                        {{ $cap->nombre }}
                      </option>
                    @endforeach
                  </select>
                </div>

                {{-- Partida --}}
                <div class="col-md-3">
                  <label>Partida</label>
                  <select name="partidas[0][id]"
                          id="partida_0_0"
                          class="form-control partida-select"
                          required>
                    <option value="">Seleccione una partida</option>
                    @foreach(
                      $capitulos
                        ->firstWhere('id', $comprobacion->partidas->first()->capitulo_id)
                        ->partidas
                      as $p
                    )
                      <option value="{{ $p->id }}"
                        {{ $comprobacion->partidas->first()->id == $p->id ? 'selected' : '' }}>
                        {{ $p->nombre }}
                      </option>
                    @endforeach
                  </select>
                </div>

                {{-- Monto Partida --}}
                <div class="col-md-3">
                  <label>Monto Partida</label>
                  <input type="number"
                         step="0.01"
                         name="partidas[0][monto]"
                         class="form-control"
                         value="{{ $comprobacion->partidas->first()->pivot->monto }}"
                         required>
                </div>
              </div>

              <div class="row mt-2">
                {{-- Tipo --}}
                <div class="col-md-3">
                  <label>Tipo</label>
                  <select name="tipo" class="form-control" required>
                    <option value="">Seleccione</option>
                    <option value="GASTO"    {{ $comprobacion->tipo=='GASTO'    ? 'selected':'' }}>GASTO</option>
                    <option value="REINTEGRO"{{ $comprobacion->tipo=='REINTEGRO'? 'selected':'' }}>REINTEGRO</option>
                    <option value="ADICIONAL"{{ $comprobacion->tipo=='ADICIONAL'? 'selected':'' }}>ADICIONAL</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="form-group">
            <button type="submit" class="btn btn-success">
              <i class="fas fa-check"></i> Actualizar Comprobación
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
  @if($errors->any())
    Swal.fire({
      icon: 'error',
      title: 'Errores en el formulario',
      html: `<ul style="text-align:left;">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>`
    });
  @endif
</script>

<script>
  const capitulos = @json($capitulos->map(fn($c)=>['id'=>$c->id,'nombre'=>$c->nombre]));
  let idx = {{ $comprobacion->partidas->count() }};

  function attachCapListener(i, selectedPartida = null) {
    const cap  = document.getElementById(`capitulo_id_${i}`);
    const part = document.getElementById(`partida_${i}_0`);

    function load() {
      part.innerHTML = '<option>Cargando…</option>';
      fetch(`{{ url('/partidas/capitulo') }}/${cap.value}`)
        .then(res => res.json())
        .then(data => {
          part.innerHTML = '<option value="">Seleccione una partida</option>';
          data.forEach(p => {
            const o = document.createElement('option');
            o.value       = p.id;
            o.textContent = `${p.nombre} - ${p.descripcion}`;
            if (p.id === selectedPartida) o.selected = true;
            part.appendChild(o);
          });
        });
    }

    cap.addEventListener('change', load);

    // Si ya había un capítulo seleccionado
    if (cap.value) {
      load();
    }
  }

  // Montar listeners en los bloques que ya existen
  @foreach($comprobacion->partidas as $i => $p)
    attachCapListener({{ $i }}, {{ $p->id }});
  @endforeach
</script>
@stop

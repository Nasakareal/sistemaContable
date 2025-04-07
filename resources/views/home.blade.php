@extends('adminlte::page')

@section('title', 'Inicio')

@section('content')
<div class="powerbi-dashboard container-fluid">
    <!-- Sección de tarjetas (Resumen) -->
    <div class="row" id="summaryCards">
        <!-- Se llenan con JS -->
    </div>

    <!-- Sección de gráficos principales -->
    <div class="row">
        <!-- Gráfico de Cuentas (Donut) -->
        <div class="col-md-6" id="cuentasContainer">
            <!-- Se llena con JS: Donuts por cuenta -->
        </div>

        <div class="col-md-6">
            <!-- Gráfico de Transacciones Diarias (Barras) con FILTRO dentro del card -->
            <div class="card mb-3 shadow card-chart">
                <div class="card-header text-white bg-dark-blue d-flex flex-wrap align-items-center justify-content-between">
                    <h3 class="card-title mb-0">Transacciones Diarias</h3>
                    <div class="d-flex flex-wrap" style="gap: 5px;">
                        <label for="fechaDesde" class="mb-0 align-self-center">Desde:</label>
                        <input type="date" id="fechaDesde" class="form-control form-control-sm" style="width:auto;">
                        
                        <label for="fechaHasta" class="mb-0 align-self-center">Hasta:</label>
                        <input type="date" id="fechaHasta" class="form-control form-control-sm" style="width:auto;">
                        
                        <button id="btnFiltrar" class="btn btn-sm btn-light">Filtrar</button>
                    </div>
                </div>
                <div class="card-body bg-card-dark">
                    <canvas id="barChartTransacciones"></canvas>
                </div>
            </div>

            <!-- Gráfico de Distribución por Tipo (Pie) -->
            <div class="card shadow card-chart">
                <div class="card-header text-white bg-dark-green">
                    <h3 class="card-title">Distribución por Tipo</h3>
                </div>
                <div class="card-body bg-card-dark text-center">
                    <!-- Contenedor con clase para restringir tamaño -->
                    <div class="small-pie-chart">
                        <canvas id="pieChartTransacciones"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Performance Highlights -->
    <div class="row mt-4" id="performanceHighlights">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header text-white bg-dark-orange">
                    <h3 class="card-title">Resumen de Rendimiento</h3>
                </div>
                <div class="card-body bg-card-dark text-center" id="highlightsContainer">
                    <!-- Llenado con JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Top 5 -->
    <div class="row mt-4" id="top5Section">
        <div class="col-md-6">
            <div class="card shadow card-chart">
                <div class="card-header text-white bg-dark-blue">
                    <h3 class="card-title">Top 5 Egresos</h3>
                </div>
                <div class="card-body bg-card-dark">
                    <table class="table table-dark table-striped" id="tableTopEgresos">
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Se llena con JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow card-chart">
                <div class="card-header text-white bg-dark-green">
                    <h3 class="card-title">Top 5 Ingresos</h3>
                </div>
                <div class="card-body bg-card-dark">
                    <table class="table table-dark table-striped" id="tableTopIngresos">
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Se llena con JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> <!-- Fin container-fluid -->
@stop

@section('css')
<style>
    /* CONTENEDOR GENERAL CON FONDO OSCURO */
    .powerbi-header {
        background: #2E3B4E; /* un azul/gris oscuro */
    }
    .powerbi-dashboard {
        background: #1f2532; /* tono oscuro */
        color: #fff;
        padding-top: 20px;
        min-height: 100vh;
    }

    /* TARJETAS DE RESUMEN (fila superior) */
    .summary-card {
        background: #2E3B4E; 
        border-radius: 6px;
        padding: 20px;
        margin-bottom: 15px;
        text-align: center;
        color: #fff;
        box-shadow: 0 3px 6px rgba(0,0,0,0.2);
    }
    .summary-card h2 {
        font-size: 2rem; 
        margin: 0;
    }
    .summary-card p {
        margin: 0;
        font-size: 1rem;
        color: #ccc;
    }

    /* CARDS DE CHARTS */
    .card-chart {
        border: none;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    .bg-card-dark {
        background: #2f3642;
    }

    /* ENCABEZADOS DE CHARTS */
    .bg-dark-blue { background: #34495e !important; }
    .bg-dark-green { background: #2ecc71 !important; }
    .bg-dark-orange { background: #e67e22 !important; }

    /* TABLAS "TOP 5" */
    .table-dark {
        background-color: #3a3f48; 
        color: #fff;
    }
    .table-dark.table-striped tbody tr:nth-of-type(odd) {
        background-color: #343a40;
    }

    /* TARJETAS DE CUENTAS (DONUT) */
    .account-card {
        background: #2f3642;
        border-radius: 6px;
        margin: 10px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.2);
        color: #fff;
        text-align: center;
    }
    .account-card-header {
        font-weight: bold;
        padding: 10px;
        background: #2E3B4E;
    }
    .account-card-body {
        padding: 10px;
    }

    .small-pie-chart {
        max-width: 300px;
        margin: 0 auto;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let globalData = null;
    let transaccionesDiariasChart = null;

    function formatMoney(value) {
        return '$' + Number(value).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // 1) Cargamos datos del endpoint (HomeController@json)
    fetch("{{ route('dashboard.json') }}")
        .then(res => res.json())
        .then(data => {
            globalData = data;

            // 2) Renderizamos secciones
            renderResumen(data);
            renderCuentas(data.cuentas);
            renderTransaccionesDiarias(data.transacciones_por_dia);
            renderDistribucionTipo(data.transacciones_por_tipo);
            renderPerformanceHighlights(data);
            renderTop5(data);
        })
        .catch(err => {
            console.error(err);
            document.getElementById('summaryCards').innerHTML = `
                <div class="col-12 text-center">
                    <p class="text-danger">Error al cargar datos.</p>
                </div>
            `;
        });

    // 3) Evento: Al dar clic en Filtrar
    document.getElementById('btnFiltrar').addEventListener('click', () => {
        if (!globalData) return;

        const desde = document.getElementById('fechaDesde').value;
        const hasta = document.getElementById('fechaHasta').value;

        let transaccionesFiltradas = globalData.transacciones_por_dia;
        if (desde && hasta) {
            transaccionesFiltradas = globalData.transacciones_por_dia.filter(t => {
                return t.fecha >= desde && t.fecha <= hasta;
            });
        }

        renderTransaccionesDiarias(transaccionesFiltradas);
    });

    // A) Tarjetas de Resumen
    function renderResumen(data) {
        const summaryCards = document.getElementById('summaryCards');
        const saldoNetoCalculado = data.cuentas.reduce((acum, c) => acum + Number(c.saldo), 0);

        summaryCards.innerHTML = `
            <div class="col-md-4">
                <div class="summary-card">
                    <h2>${formatMoney(data.summary.total_ingresos)}</h2>
                    <p>Total Ingresos</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <h2>${formatMoney(data.summary.total_egresos)}</h2>
                    <p>Total Egresos</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <h2>${formatMoney(saldoNetoCalculado)}</h2>
                    <p>Saldo Neto</p>
                </div>
            </div>
        `;
    }

    // B) Donuts (Cuentas)
    function renderCuentas(cuentas) {
        const container = document.getElementById('cuentasContainer');
        let totalSaldos = cuentas.reduce((acum, c) => acum + Number(c.saldo), 0);
        let html = `<div class="card card-chart mb-3">
            <div class="card-header text-white bg-dark-blue">
                <h3 class="card-title">Saldos por Cuenta Bancaria</h3>
            </div>
            <div class="card-body bg-card-dark">
                <div class="row">
        `;

        cuentas.forEach((cuenta, idx) => {
            let saldo = Number(cuenta.saldo);
            let porcentaje = (totalSaldos > 0) ? (saldo / totalSaldos) * 100 : 0;

            html += `
                <div class="col-md-6 col-lg-4">
                    <div class="account-card">
                        <div class="account-card-header">
                            ${cuenta.nombre}
                        </div>
                        <div class="account-card-body">
                            <canvas id="chartCuenta${idx}" style="height:150px;"></canvas>
                            <p style="margin-top:10px;">
                                <strong>Saldo:</strong> ${formatMoney(saldo)} <br>
                                <small>(${porcentaje.toFixed(2)}% del total)</small>
                            </p>
                        </div>
                    </div>
                </div>
            `;
        });

        html += `</div></div></div>`;
        container.innerHTML = html;

        // Para cada cuenta, renderizamos un donut
        cuentas.forEach((cuenta, idx) => {
            let saldo = Number(cuenta.saldo);
            let porcentaje = (totalSaldos > 0) ? (saldo / totalSaldos) * 100 : 0;
            let ctx = document.getElementById(`chartCuenta${idx}`).getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [porcentaje, 100 - porcentaje],
                        backgroundColor: ['#2ecc71', '#3a3f48']
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if(context.dataIndex === 0) {
                                        return porcentaje.toFixed(2) + '%';
                                    }
                                    return null;
                                }
                            }
                        }
                    }
                }
            });
        });
    }

    // C) Gráfico de Barras (Transacciones Diarias)
    function renderTransaccionesDiarias(transacciones) {
        const ctxBar = document.getElementById('barChartTransacciones').getContext('2d');

        if (transaccionesDiariasChart) {
            transaccionesDiariasChart.destroy();
        }

        let labels = transacciones.map(t => t.fecha);
        let ingresos = transacciones.map(t => t.ingresos);
        let egresos = transacciones.map(t => t.egresos);

        transaccionesDiariasChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Ingresos',
                        data: ingresos,
                        backgroundColor: '#2ecc71'
                    },
                    {
                        label: 'Egresos',
                        data: egresos,
                        backgroundColor: '#e74c3c'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { position: 'top' },
                    title: { display: false }
                }
            }
        });
    }

    // D) Pie Chart (Distribución por Tipo)
    function renderDistribucionTipo(transPorTipo) {
        const ctxPie = document.getElementById('pieChartTransacciones').getContext('2d');
        let ingreso = transPorTipo.ingreso ?? 0;
        let egreso  = transPorTipo.egreso ?? 0;

        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Ingresos', 'Egresos'],
                datasets: [{
                    data: [ingreso, egreso],
                    backgroundColor: ['#27ae60', '#c0392b']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { color: '#fff' } },
                    title: { display: false }
                }
            }
        });
    }

    // E) Performance Highlights
    function renderPerformanceHighlights(data) {
        const container = document.getElementById('highlightsContainer');
        
        let rentabilidad = 0;
        if (data.summary.total_egresos > 0) {
            rentabilidad = ((data.summary.total_ingresos - data.summary.total_egresos) / data.summary.total_egresos) * 100;
        }

        let margen = 0;
        if (data.summary.total_ingresos > 0) {
            margen = ((data.summary.total_ingresos - data.summary.total_egresos) / data.summary.total_ingresos) * 100;
        }

        container.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <h5 class="text-white">Rentabilidad</h5>
                    <h2 style="color: #2ecc71;">${rentabilidad.toFixed(2)}%</h2>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white">Margen</h5>
                    <h2 style="color: #f1c40f;">${margen.toFixed(2)}%</h2>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white">Estado General</h5>
                    <h2 style="color: ${(data.summary.total_ingresos >= data.summary.total_egresos) ? '#2ecc71' : '#e74c3c'};">
                        ${(data.summary.total_ingresos >= data.summary.total_egresos) ? 'Positivo' : 'Negativo'}
                    </h2>
                </div>
            </div>
        `;
    }

    function renderTop5(data) {
        const topEgresos = data.top_egresos ?? [];
        const topIngresos = data.top_ingresos ?? [];

        const tbodyEgresos = document.querySelector('#tableTopEgresos tbody');
        const tbodyIngresos = document.querySelector('#tableTopIngresos tbody');

        tbodyEgresos.innerHTML = topEgresos.map(item => `
            <tr>
                <td>${item.concepto}</td>
                <td>${formatMoney(item.monto)}</td>
            </tr>
        `).join('');

        tbodyIngresos.innerHTML = topIngresos.map(item => `
            <tr>
                <td>${item.concepto}</td>
                <td>${formatMoney(item.monto)}</td>
            </tr>
        `).join('');
    }
});
</script>
@stop

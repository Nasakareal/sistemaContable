@extends('adminlte::page')

@section('title', 'Sistema Financiero')

@section('content_header')
    <center><h1>Sistema Financiero</h1></center>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Tarjetas Resumen -->
        <div class="row" id="summaryCards">
            <!-- Se llenarán dinámicamente -->
        </div>

        <!-- Gráfico de Cuentas (Donut) -->
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">Saldos por Cuenta Bancaria</h3>
                    </div>
                    <div class="card-body">
                        <div class="row" id="cuentasContainer">
                            <!-- Cada cuenta tendrá su tarjeta con gráfico donut -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Transacciones Diarias (Barras) -->
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Transacciones Diarias</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="barChartTransacciones"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Distribución por Tipo (Pastel) -->
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Distribución por Tipo de Transacción</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChartTransacciones"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Tarjetas Resumen */
        .summary-card {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .summary-card h3 {
            margin: 0;
            font-size: 2rem;
        }
        .summary-card p {
            margin: 0;
            font-size: 1rem;
            color: #6c757d;
        }
        /* Tarjetas de Cuenta */
        .cuenta-card {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
        }
        .chart-container {
            width: 100%;
            height: 150px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("{{ route('dashboard.json') }}", {
                headers: {
                    "Authorization": "Bearer {{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                let summaryContainer = document.getElementById("summaryCards");
                summaryContainer.innerHTML = `
                    <div class="col-md-4">
                        <div class="summary-card">
                            <h3>$${Number(data.summary.total_ingresos).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</h3>
                            <p>Total Ingresos</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-card">
                            <h3>$${Number(data.summary.total_egresos).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</h3>
                            <p>Total Egresos</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-card">
                            <h3>$${Number(data.summary.saldo_neto).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</h3>
                            <p>Saldo Neto</p>
                        </div>
                    </div>
                `;

                let cuentasContainer = document.getElementById("cuentasContainer");
                let cuentasHTML = "";
                data.cuentas.forEach((cuenta, index) => {
                    let saldo = Number(cuenta.saldo);
                    cuentasHTML += `
                        <div class="col-md-4 col-sm-6">
                            <div class="card cuenta-card">
                                <div class="card-header bg-light">
                                    <h5 class="card-title">${cuenta.nombre}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartCuenta${index}"></canvas>
                                    </div>
                                    <p><strong>Saldo:</strong> $${saldo.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                cuentasContainer.innerHTML = cuentasHTML;

                data.cuentas.forEach((cuenta, index) => {
                    let saldo = Number(cuenta.saldo);
                    let porcentaje = saldo > 0 ? 100 : 0;
                    let color = saldo > 0 ? "#28a745" : "#e0e0e0";
                    let ctx = document.getElementById(`chartCuenta${index}`).getContext("2d");
                    new Chart(ctx, {
                        type: "doughnut",
                        data: {
                            datasets: [{
                                data: [porcentaje, 100 - porcentaje],
                                backgroundColor: [color, "#e0e0e0"]
                            }]
                        },
                        options: {
                            responsive: true,
                            cutout: "80%",
                            plugins: {
                                tooltip: { enabled: false },
                                legend: { display: false }
                            }
                        }
                    });
                });

                let barCtx = document.getElementById("barChartTransacciones").getContext("2d");
                let dias = data.transacciones_por_dia.map(item => item.fecha);
                let ingresos = data.transacciones_por_dia.map(item => item.ingresos);
                let egresos = data.transacciones_por_dia.map(item => item.egresos);
                new Chart(barCtx, {
                    type: "bar",
                    data: {
                        labels: dias,
                        datasets: [
                            {
                                label: "Ingresos",
                                data: ingresos,
                                backgroundColor: "#28a745"
                            },
                            {
                                label: "Egresos",
                                data: egresos,
                                backgroundColor: "#dc3545"
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: 'Transacciones Diarias' }
                        }
                    }
                });

                // 4. Gráfico de Distribución por Tipo (Pastel)
                let pieCtx = document.getElementById("pieChartTransacciones").getContext("2d");
                new Chart(pieCtx, {
                    type: "pie",
                    data: {
                        labels: ["Ingresos", "Egresos"],
                        datasets: [{
                            data: [data.transacciones_por_tipo.ingreso, data.transacciones_por_tipo.egreso],
                            backgroundColor: ["#28a745", "#dc3545"]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: 'Distribución de Transacciones por Tipo' }
                        }
                    }
                });
            })
            .catch(error => {
                document.getElementById("dashboardContainer").innerHTML = `
                    <div class='col-12 text-center'>
                        <p class='text-danger'>Error al cargar datos.</p>
                    </div>
                `;
                console.error("Error al cargar datos:", error);
            });
        });
    </script>
@stop

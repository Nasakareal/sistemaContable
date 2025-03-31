@extends('adminlte::page')

@section('title', 'Sistema Financiero')

@section('content_header')
    <center><h1>Sistema Financiero</h1></center>
@stop

@section('content')
    <div class="row" id="dashboardContainer">
        <!-- Las tarjetas se generarán dinámicamente -->
    </div>
@stop

@section('css')
    <style>
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
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Se asume que hemos creado una ruta 'dashboard.json'
            fetch("{{ route('dashboard.json') }}", {
                headers: {
                    "Authorization": "Bearer {{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                let container = document.getElementById("dashboardContainer");

                if (data.length === 0) {
                    container.innerHTML = `<div class='col-12 text-center'><p class='text-muted'>No hay cuentas registradas.</p></div>`;
                    return;
                }

                let cardHtml = "";
                data.forEach((cuenta, index) => {
                    // Supongamos que definimos una meta (por ejemplo, 10,000) para calcular un porcentaje
                    let meta = 10000;
                    let porcentaje = Math.min(100, Math.round((cuenta.saldo / meta) * 100));
                    let color = porcentaje < 50 ? "#dc3545" : porcentaje < 80 ? "#ffc107" : "#28a745";

                    cardHtml += `
                        <div class="col-md-4 col-sm-6">
                            <div class="card cuenta-card border-${porcentaje < 50 ? 'danger' : porcentaje < 80 ? 'warning' : 'success'}">
                                <div class="card-header bg-light">
                                    <h5 class="card-title">${cuenta.nombre}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chart${index}"></canvas>
                                    </div>
                                    <p><strong>Saldo:</strong> $${cuenta.saldo}</p>
                                    <p><strong>Porcentaje Meta:</strong> ${porcentaje}%</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                container.innerHTML = cardHtml;

                // Generar los gráficos
                data.forEach((cuenta, index) => {
                    let meta = 10000;
                    let porcentaje = Math.min(100, Math.round((cuenta.saldo / meta) * 100));
                    let color = porcentaje < 50 ? "#dc3545" : porcentaje < 80 ? "#ffc107" : "#28a745";

                    let ctx = document.getElementById(`chart${index}`).getContext("2d");
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

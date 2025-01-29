@include('components.header')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metricas-PageSpeed</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/DataTables/datatables.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('/css/metrics/index.css') }}" rel="stylesheet">

</head>

<body>
    <div class="container text-center">
        <h1>Metricas-PageSpeed</h1>
    </div>
    <div class="container switch text-center">
        <button type="button" class="btn btn-info text-white me-2 button-run-metrics">Run Metrics</button>
        <button type="button" class="btn btn-secondary text-white button-history-metrics">Metric History</button>
    </div>
    <div class="container section" id="run-metrics-section">
        <form id="metrics-form">
            <div class="">
                <div class="row">
                    <div class="col-md-3 form-group form-group-url">
                        <label for="url" class="form-label">URL:</label>
                        <input type="text" id="url" name="url" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group form-group-categories text-center">
                        <label class="form-label">Categories:</label>
                        <div class="checkbox-group">
                            @foreach ($categories as $category)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="categories[]"
                                        value="{{ $category->name }}">
                                    <label class="form-check-label">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-3 form-group form-group-strategy">
                        <label for="strategy" class="form-label">Strategy:</label>
                        <select id="strategy" name="strategy" class="form-select" required>
                            @foreach ($strategies as $strategy)
                                <option value="{{ $strategy->id }}">{{ $strategy->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-info text-white">Get Metrics</button>
            </div>
        </form>
        <div class="w-100">
            <div id="loading" class="loader m-auto"></div>
        </div>
        <div id="results" class="text-center"></div>
    </div>

    <div class="container text-center section" id="metric-chart-section">
        <h1>Metrics Charts</h1>
        <div style="width: 50%; margin: auto;">
            <canvas id="myChart" width="200" height="100"></canvas>
        </div>
    </div>

    <div class="container section" id="metric-history-section">
        <h1 class="text-center">Metric History</h1>
        <div class="table-responsive">
            <table id="datatable" style="width: 100%" class="table table-striped ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>URL</th>
                        <th>Accesibility Metric</th>
                        <th>PWA Metric</th>
                        <th>Performance Metric</th>
                        <th>SEO Metric</th>
                        <th>Best Practices Metric</th>
                        <th>Strategy</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="/DataTables/datatables.js"></script>
    <script>
        $(document).ready(function() {

            $('#loading').hide();
            $('#run-metrics-section').addClass('active');
            $('#metric-chart-section').addClass('active');

            $('.button-run-metrics').on('click', function() {
                $('.section').removeClass('active');
                $('#run-metrics-section').addClass('active');
                $('#metric-chart-section').addClass('active');

                $('.button-history-metrics').removeClass('btn-info');
                $('.button-history-metrics').addClass('btn-secondary');
                $('.button-run-metrics').removeClass('btn-secondary');
                $('.button-run-metrics').addClass('btn-info');

            });
            $('.button-history-metrics').on('click', function() {
                $('.section').removeClass('active');
                $('#metric-history-section').addClass('active');

                $('.button-history-metrics').removeClass('btn-secondary');
                $('.button-history-metrics').addClass('btn-info');
                $('.button-run-metrics').removeClass('btn-info');
                $('.button-run-metrics').addClass('btn-secondary');
            });

            $('#metrics-form').on('submit', function(event) {
                event.preventDefault();

                var url = $('#url').val();
                var categories = $('input[name="categories[]"]:checked').map(function() {
                    return this.value;
                }).get();
                var strategy = $('#strategy').val();

                $('#loading').show();
                $('#results').hide();

                $.ajax({
                    url: "{!! route('metrics.get') !!}",
                    method: 'GET',
                    data: {
                        url: url,
                        categories: categories,
                        strategy: strategy
                    },
                    success: function(data) {
                        $('#loading').hide();

                        var resultsHtml = '';

                        for (var category in data) {
                            var score = Math.round(data[category] * 100);
                            var scoreClass = 'high'; // Por defecto

                            if (score < 50) {
                                scoreClass = 'low';
                            } else if (score < 90) {
                                scoreClass = 'medium';
                            }

                            resultsHtml += '<div class="result-card" data-score="' +
                                scoreClass + '">';
                            resultsHtml += '<div class="result-title">' + category
                                .toUpperCase() + '</div>';
                            resultsHtml += '<div class="result-score">' + score + '%</div>';
                            resultsHtml += '</div>';
                        }

                        $('#results').show();
                        $('#results').html(resultsHtml);

                        createChart(categories, data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#loading').hide();
                        $('#results').show().html('Error: ' + errorThrown);
                    }

                });
            });

            function createChart(categories, scores) {
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: categories.map(function(category) {
                            return category.toUpperCase();
                        }),
                        datasets: [{
                            label: 'Scores',
                            data: categories.map(function(category) {
                                return Math.round(scores[category] *
                                100); // Convertir a porcentaje
                            }),
                            backgroundColor: categories.map(function(category) {
                                var score = scores[category] * 100;
                                if (score < 50) {
                                    return 'rgba(255, 99, 132, 0.7)'; // Rojo
                                } else if (score < 90) {
                                    return 'rgba(255, 206, 86, 0.7)'; // Amarillo
                                } else {
                                    return 'rgba(75, 192, 192, 0.7)'; // Verde
                                }
                            }),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100 // Establecer el máximo en 100%
                            }
                        }
                    }
                });
            }

            $('#datatable').DataTable({
                paging: false,
                processing: true,
                serverSide: true,
                ajax: '{!! route('metrics.datatable') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'url',
                        name: 'url'
                    },
                    {
                        data: 'accesibility_metric',
                        name: 'accesibility_metric'
                    },
                    {
                        data: 'pwa_metric',
                        name: 'pwa_metric'
                    },
                    {
                        data: 'performance_metric',
                        name: 'performance_metric'
                    },
                    {
                        data: 'seo_metric',
                        name: 'seo_metric'
                    },
                    {
                        data: 'best_practices_metric',
                        name: 'best_practices_metric'
                    },
                    {
                        data: 'strategy_id',
                        name: 'strategy_id'
                    }
                ],
            });
        });
    </script>
</body>

</html>

@extends('layouts.main')

@section('content')

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>{{ $budgetName }} | โครงสร้างการจ้าง</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/job.css') }}" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>

    <style>
        .header {
            background-color: #6a1b9a;
            color: white;
            padding: 2rem 1rem;
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            border-bottom: 5px solid #b39ddb;
            margin-bottom: 2rem;
        }

        /* .container {
            max-width: 1100px;
            margin: auto;
            background: #ffffffee;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(106, 27, 154, 0.08);
        } */

        .chart-box {
            margin-bottom: 2rem;
        }

        h2 {
            color: #4a0072;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
        }

        table {
            border-radius: 12px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(106, 27, 154, 0.05);
        }

        thead th {
            background-color: #4a0072;
            color: white;
            font-weight: 600;
        }

        tbody td {
            vertical-align: middle;
        }

        tr.total td {
            background-color: #ede7f6;
            font-weight: bold;
            color: #4a0072;
        }

        a {
            color: #6a1b9a;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            color: #4a0072;
            text-decoration: underline;
        }

        button.back-btn {
            margin: 1rem;
            padding: 0.6rem 1.2rem;
            background-color: #6a1b9a;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .header {
                font-size: 1.4rem;
            }
        }

    </style>
</head>

<body>
    <div class="topbar">
        <button onclick="history.back()" class="goback-btn">← กลับหน้าก่อนหน้า</button>
        <div class="navbar-title">{{ $budgetName }}</div>
    </div>


    <div class="container">
        <div class="chart-box">
            <canvas id="jobChart"></canvas>
        </div>

        <h2>รายละเอียดตามประเภทการจ้าง</h2>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ประเภทการจ้าง</th>
                    <th>จำนวน</th>
                    <th>ร้อยละ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $index => $job)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <a href="{{ url('/person_detail?id=' . $job->job_id . '&budget=' . $id) }}">
                            {{ $job->job_name }}
                        </a>


                    </td>
                    <td>{{ $job->total }}</td>
                    <td>{{ number_format(($job->total / $allCount) * 100, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total">
                    <td></td>
                    <td>รวม</td>
                    <td>{{ $allCount }}</td>
                    <td>100%</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- แทรกข้อมูล jobs แบบไม่ Error -->
    <script id="chart-data" type="application/json">
        {
            !!$jobs - > toJson() !!
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartItems = @json($jobs);
            const chartLabels = chartItems.map(item => item.job_name);
            const chartData = chartItems.map(item => item.total);

            const backgroundColors = [
                '#7e57c2', '#9575cd', '#ba68c8', '#ce93d8',
                '#f48fb1', '#ffb74d', '#4db6ac', '#64b5f6',
                '#81c784', '#ffd54f', '#e57373', '#a1887f'
            ];

            const ctx = document.getElementById('jobChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'จำนวนบุคลากร',
                        data: chartData,
                        backgroundColor: backgroundColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'right',
                            color: '#333',
                            font: {
                                weight: 'bold',
                                size: 12
                            },
                            formatter: function(value, ctx) {
                                const total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                const percent = ((value / total) * 100).toFixed(1);
                                return `${value} คน (${percent}%)`;
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percent = ((context.raw / total) * 100).toFixed(1);
                                    return `${context.label}: ${context.raw} คน (${percent}%)`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                color: '#6a1b9a'
                            },
                            title: {
                                display: true,
                                text: 'จำนวน (คน)',
                                color: '#6a1b9a',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        },
                        y: {
                            ticks: {
                                color: '#6a1b9a',
                                font: {
                                    size: 13
                                }
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        });
    </script>

</body>

</html>

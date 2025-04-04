@extends('layouts.main')

@section('content')
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>โครงสร้างการจ้าง</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script>
    <link rel="stylesheet" href="{{ asset('css/structure.css') }}" type="text/css" />
</head>

<body>


    <div class="topbar">
        <button onclick="history.back()" class="goback-btn">← กลับหน้าก่อนหน้า</button>
        <div class="navbar-title">ข้อมูลบุคลากรภายนอก คณะแพทยศาสตร์</div>
    </div>



    <div class="wrapper">
        <h2>โครงสร้างบุคลากรภายนอก - แบ่งตามงบการจ้าง</h2>

        <div class="container">
            <!-- ซ้าย: Chart -->
            <div class="box">
                <div class="box-header">เปรียบเทียบงบการจ้าง (กราฟวงกลม)</div>
                <div class="box-content">
                    <canvas id="budgetChart"></canvas>
                    <div id="customLegend" class="custom-legend"></div>
                </div>
            </div>

            <!-- ขวา: ตาราง -->
            <div class="box box-shift-down">
                <div class="box-header">โครงสร้าง - แบ่งตามงบการจ้าง</div>
                <div class="box-content">
                    <table>
                        <thead>
                            <tr>
                                <th>งบการจ้าง</th>
                                <th>จำนวน</th>
                                <th>ร้อยละ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($structures as $row)
                            <tr>
                                <td>
                                    <a href="{{ url('/job?id=' . ($row->tbudget_id ?? 0)) }}">
                                        {{ $row->budget_name ?? 'ไม่พบงบประมาณ' }}
                                    </a>
                                </td>
                                <td>{{ $row->total }}</td>
                                <td>{{ number_format($row->percentage, 1) }}%</td>
                            </tr>
                            @endforeach
                            <tr class="total">
                                <td>รวม</td>
                                <td>{{ $sumTotal }}</td>
                                <td>100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const chartLabels = @json($labels);
        const chartData = @json($data);

        const generateColors = (num) => {
            const colors = [
                "#8e24aa", "#ab47bc", "#ba68c8", "#ce93d8",
                "#f06292", "#ffb74d", "#4db6ac", "#64b5f6",
                "#aed581", "#fff176", "#e57373", "#a1887f",
                "#42a5f5", "#26a69a", "#7e57c2", "#78909c",
                "#ff8a65", "#ffca28", "#d4e157", "#9ccc65",
                "#26c6da", "#5c6bc0", "#ec407a", "#ffa726"
            ];

            while (colors.length < num) {
                colors.push('#' + Math.floor(Math.random() * 16777215).toString(16));
            }
            return colors.slice(0, num);
        };

        const backgroundColors = generateColors(chartLabels.length);

        const ctx = document.getElementById('budgetChart').getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartLabels,
                datasets: [{
                    data: chartData,
                    backgroundColor: backgroundColors,
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                const percent = ((context.raw / total) * 100).toFixed(1);
                                return `${context.label}: ${context.raw} คน (${percent}%)`;
                            }
                        },
                        backgroundColor: '#4a0072',
                        titleFont: {
                            size: 30
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 10,
                        cornerRadius: 6
                    },
                    datalabels: {
                        color: '#000',
                        font: {
                            weight: 'regular',
                            size: 40
                        },
                        formatter: function(value, context) {
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return [`${value} คน`, `(${percentage}%)`];
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        const total = chartData.reduce((sum, item) => sum + item, 0);
        const legendContainer = document.getElementById('customLegend');
        legendContainer.innerHTML = '';

        chartLabels.forEach((label, index) => {
            const percent = ((chartData[index] / total) * 100).toFixed(1);
            const row = document.createElement('div');
            row.className = 'legend-row';
            row.innerHTML = `
            <span class="legend-color" style="background-color: ${backgroundColors[index]}"></span>
            <span class="legend-label">${label} – ${percent}%</span>
        `;
            legendContainer.appendChild(row);
        });
    </script>

</body>

</html>

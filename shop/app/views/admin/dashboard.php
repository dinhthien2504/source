<div class="custom-admin__content">
    <div class="custom-content__title">
        <h3>Dashboard</h3>
    </div>
    <div class="custom-content__show p-3">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-end mb-4">
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Xuất báo cáo</a>
            </div>
            <!-- Content Row -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="text-decoration-none card border-left-primary shadow h-100 py-2 text-decoration-none "
                        href="<?= _WEB_ROOT_ ?>/admin/categories">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-primary text-uppercase mb-1 fs-15">
                                        Tổng danh mục</div>
                                    <div class="mb-0 fw-bold text-gray-800"><?= $total_cate['total'] ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="card border-left-success shadow h-100 py-2 text-decoration-none "
                        href="<?= _WEB_ROOT_ ?>/admin/products">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-success text-uppercase mb-1 fs-15">
                                        Tổng sản phẩm</div>
                                    <div class="mb-0 fw-bold text-gray-800"><?= $total_pro['total'] ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="card border-left-info shadow h-100 py-2 text-decoration-none "
                        href="<?= _WEB_ROOT_ ?>/admin/orders">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class=" text-info text-uppercase mb-1 fs-15">
                                        Tổng đơn hàng
                                    </div>
                                    <div class="mb-0 fw-bold text-gray-800"><?= $total_order['total'] ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="card border-left-warning shadow h-100 py-2 text-decoration-none "
                        href="<?= _WEB_ROOT_ ?>/admin/orders?status=1">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-warning text-uppercase mb-1 fs-15">
                                        Đơn hàng mới</div>
                                    <div class="mb-0 fw-bold text-gray-800"><?= $total_order_new['total'] ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Area Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Tổng quan doanh thu</h6>
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myAreaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow overflow-hidden">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">TỈ LỆ HÀNG HÓA</h6>
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </div>
                        <!-- Card Body -->
                        <div class="chart-pie" id="myChart" style="width:100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->
<script src="<?= _WEB_ROOT_ ?>/public/assets/js/chart/Chart.min.js"></script>
<script src="<?= _WEB_ROOT_ ?>/public/assets/js/chart/loader.js"></script>

<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    // Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    // Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
    var months = <?php
    echo json_encode($months_js);
    ?>;
    var totals = <?php
    echo json_encode($totals_js);
    ?>;
    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: "Thu nhập: ",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: totals,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                            return number_format(value) + 'đ';
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function (tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + number_format(tooltipItem.yLabel) + 'đ';
                    }
                }
            }
        }
    });



    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        // Set Data
        const data = google.visualization.arrayToDataTable([
            ['nameCate', 'quantity'],
            <?php
            foreach ($data_chart as $item) {
                echo "['" . $item['cate_name'] . "', " . $item['quantity'] . "],";
            }
            ?>
        ]);
        // Set Options
        const options = {
            is3D: true,
            legend: { position: 'right', alignment: 'center' }
        };
        // Draw
        const chart = new google.visualization.PieChart(document.getElementById('myChart'));
        chart.draw(data, options);
    }

</script>
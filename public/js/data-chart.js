$(document).ready(function() {
    // Call API to get data Sup Admin & Admin
    $.ajax({
        url: '/data-chart',
        method: 'GET',
        success: function(response) {
            if (response.status === 'success') {
                // Get data from API
                const data = {
                    total_users: response.data.total_users,
                    total_admins: response.data.total_admins,
                    success_task: response.data.success_task,
                    total_customers: response.data.total_customers,
                    success_task_per_day: response.data.success_task_per_day
                }

                const tasksPerDay = data.success_task_per_day;

                const labels = tasksPerDay.map(item => item.date);
                const taskCounts = tasksPerDay.map(item => item.task_count);
                
                // Call function to draw chart
                getDataAreaChart('myAreaChart', labels, taskCounts);
                getDataPieChart('myPieChart', ['Admin', 'Teknisi'], [data.total_admins, data.total_users]);

            } else {
                console.error('Error: ' + response.message);
            }
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });

    function getDataAreaChart(id, label, taskCount) {
        let ctx = document.getElementById(id);
        let myLineChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: label,
                datasets: [
                    {
                        label: "Tugas Selesai",
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
                        data: taskCount,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0,
                    },
                },
                scales: {
                    xAxes: [
                        {
                            time: {
                                unit: "date",
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                maxTicksLimit: 7,
                            },
                        },
                    ],
                    yAxes: [
                        {
                            ticks: {
                                min: 0,
                                max: Math.max(...taskCount) + 5,
                                maxTicksLimit: 5,
                                padding: 10,
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2],
                            },
                        },
                    ],
                },
                legend: {
                    display: false,
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: "#6e707e",
                    titleFontSize: 14,
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: "index",
                    caretPadding: 10,
                },
            },
        });
    }

    function getDataPieChart(id, label, datas) {
        let pieChart = document.getElementById(id);
        let myPieChart = new Chart(pieChart, {
            type: "doughnut",
            data: {
                labels: label,
                datasets: [{
                    data: datas,
                    backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
                    hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false,
                },
                cutoutPercentage: 80,
            },
        });
    }
});
let performanceChartInstance = null;
let inventoryChartInstance = null;

function initGraphs() {
    refreshGraph();
}

function refreshGraph() {
    const loaderText = document.querySelector('#graph-loader span');

    const endpoint = window.location.pathname.includes('profile')
    ? 'profile.php?ajax=graph'
    : 'dashboard.php?ajax=graph';

    fetch(endpoint)
        .then(res => res.json())
        .then(data => {
            const canvas = document.getElementById('performanceChart');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                
                if (performanceChartInstance) performanceChartInstance.destroy();
                if (!data.line) return;

                const labels = data.line.map(d => months[d.month - 1]);
                const values = data.line.map(d => d.total);

                if (window.myChart) {
                    window.myChart.destroy();
                    window.myChart = null;
                }

                window.myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            borderColor: '#007bff',
                            tension: 0.3,
                            fill: true,
                            backgroundColor: 'rgba(0, 123, 255, 0.1)'
                        }]
                    },
                    options: {
                        plugins: { 
                            legend: { display: false } 
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                suggestedMax: Math.max(...values) + 20, 
                                ticks: {
                                    precision: 0 
                                }
                            }
                        }
                    }
                })
            }

            const pie = document.getElementById("pieChart");
            if (pie && data.pie) {
                const labels = Object.keys(data.pie);
                const values = labels.map(l => data.pie[l].value);
                const colors = labels.map(l => data.pie[l].color);

                if (inventoryChartInstance) inventoryChartInstance.destroy();

                inventoryChartInstance = new Chart(pie.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                enabled: true,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let actualCount = data.pie[label].count; 
                                        return ` ${label}: ${actualCount} Items`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            if (data.stats) {
                const fields = {
                    'stat-overdue': data.stats.overdue,
                    'stat-open': data.stats.open,
                    'stat-unresolved': data.stats.status,
                    'stat-urgent': data.stats.urgent
                };
                for (const [id, val] of Object.entries(fields)) {
                    const el = document.getElementById(id);
                    if (el) el.innerText = val;
                }
            }
        
            ['graph-loader1', 'graph-loader2'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
            
        }).catch(err => console.error("Graph update failed:", err));
}

document.addEventListener("DOMContentLoaded", function () {
    refreshGraph();
    refreshActivity();

    setInterval(refreshActivity, 10000);
    setInterval(refreshGraph, 20000);
});
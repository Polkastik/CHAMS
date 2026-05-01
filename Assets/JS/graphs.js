if (window.myChart) {
    window.myChart.destroy();
}

function initGraphs() {

    const pie = document.getElementById("pieChart");
    if (pie) {
        const chartData = JSON.parse(pie.dataset.chart || '{}');

        let start = 0;
        let gradientParts = [];

        for (let name in chartData) {
            let entry = chartData[name];
            let value = entry.value;
            let color = entry.color;

            if (value <= 0) continue;

            let end = start + value;
            gradientParts.push(`${color} ${start}% ${end}%`);

            start = end;
        }

        if (gradientParts.length > 0) {
            pie.style.background = `conic-gradient(${gradientParts.join(',')})`;
        }
    }

    const lineCanvas = document.getElementById('performanceChart');
    if (lineCanvas) {
        const ctx = lineCanvas.getContext('2d');

        const rawData = JSON.parse(lineCanvas.dataset.values || '[]');

        const labels = (data.line || []).map(d => "Week " + d.week);
        const values = (data.line || []).map(d => d.total);

        if (window.myChart) window.myChart.destroy();

        window.myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    tension: 0.3
                }]
            },
            options: {
                plugins: { legend: { display: false } }
            }
        });
    }
}

function refreshGraph() {
    const loaderText = document.querySelector('#graph-loader span');

    get('dashboard.php?ajax=graph')
        .then(res => {
            const data = JSON.parse(res);

            const canvas = document.getElementById('performanceChart');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                const labels = data.line.map(d => months[d.month - 1]);
                const values = data.line.map(d => d.total);

                if (window.myChart) window.myChart.destroy();
                window.myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            tension: 0.3
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
                });
            }

            const pie = document.getElementById("pieChart");
            if (pie) {
                let start = 0;
                let gradientParts = [];

                for (let name in data.pie) {
                    let entry = data.pie[name];
                    if (entry.value <= 0) continue;

                    let end = start + entry.value;
                    gradientParts.push(`${entry.color} ${start}% ${end}%`);
                    start = end;
                }

                if (gradientParts.length > 0) {
                    pie.style.background = `conic-gradient(${gradientParts.join(',')})`;
                }
            }

            if (data.stats) {
                document.getElementById('stat-overdue').innerText = data.stats.overdue;
                document.getElementById('stat-open').innerText = data.stats.open;
                document.getElementById('stat-unresolved').innerText = data.stats.status;
                document.getElementById('stat-urgent').innerText = data.stats.urgent;
            }
        
            const loader = document.getElementById('graph-loader1');
            const loader2 = document.getElementById('graph-loader2');
            if (loader) loader.style.display = 'none';
            if (loader2) loader2.style.display = 'none';
            
        })
        .catch(err => console.error("Update failed:", err));
}

document.addEventListener("DOMContentLoaded", function () {
    refreshGraph();
    refreshActivity();

    setInterval(refreshActivity, 10000);
    setInterval(refreshGraph, 20000);
});
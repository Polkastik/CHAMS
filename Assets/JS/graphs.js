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
                })
            }

            const pie = document.getElementById("pieChart");
            if (pie && data.pie) {
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
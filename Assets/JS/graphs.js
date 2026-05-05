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

<<<<<<< HEAD
    get('dashboard.php?ajax=graph')
        .then(res => {
            const data = JSON.parse(res);

=======
    const endpoint = window.location.pathname.includes('profile')
    ? 'profile.php?ajax=graph'
    : 'dashboard.php?ajax=graph';

    fetch(endpoint)
        .then(res => res.json())
        .then(data => {
>>>>>>> 7f37e85 (CHAMS VERSION 1)
            const canvas = document.getElementById('performanceChart');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
<<<<<<< HEAD
                const labels = data.line.map(d => months[d.month - 1]);
                const values = data.line.map(d => d.total);

                if (window.myChart) window.myChart.destroy();
=======
                
                if (!data.line) return;

                const labels = data.line.map(d => months[d.month - 1]);
                const values = data.line.map(d => d.total);

                if (window.myChart) {
                    window.myChart.destroy();
                    window.myChart = null;
                }

>>>>>>> 7f37e85 (CHAMS VERSION 1)
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
<<<<<<< HEAD
                });
            }

            const pie = document.getElementById("pieChart");
            if (pie) {
=======
                })
            }

            const pie = document.getElementById("pieChart");
            if (pie && data.pie) {
>>>>>>> 7f37e85 (CHAMS VERSION 1)
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
<<<<<<< HEAD
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
=======
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
>>>>>>> 7f37e85 (CHAMS VERSION 1)
}

document.addEventListener("DOMContentLoaded", function () {
    refreshGraph();
    refreshActivity();

    setInterval(refreshActivity, 10000);
    setInterval(refreshGraph, 20000);
});
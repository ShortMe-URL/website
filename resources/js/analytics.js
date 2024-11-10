const clicksChart = document.getElementById('clicksChart');


fetch('/dashboard/mylinksdata').then(response => response.json()).then(data => {
    const months = data.map(item => item.month.slice(0, 3));
    const clicks = data.map(item => item.clicks_count);
    const links = data.map(item => item.links_count);

    new Chart(clicksChart, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: "Links",
                data: links,
                borderColor: 'rgb(76, 166, 231, 70%)',
                backgroundColor: 'rgb(76, 166, 231, 50%)',
                borderWidth: 2,
                fill: {
                    target: 'origin',
                    above: 'rgb(76, 166, 231, 50%)'
                },
                tension: 0.4,
            }, {
                label: "Clicks",
                data: clicks,
                borderColor: 'rgb(76, 231, 171, 70%)',
                backgroundColor: 'rgb(76, 231, 171, 50%)',
                borderWidth: 2,
                fill: {
                    target: 'origin',
                    above: 'rgb(76, 231, 171, 50%)'
                },
                tension: 0.4,
            }]
        },
        options: {
            interaction: {
                intersect: false,
            },
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                }
            }
        }
    });
});
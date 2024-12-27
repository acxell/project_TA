document.addEventListener("DOMContentLoaded", function () {
    fetch("/dashboard-data")
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            const optionsProfileVisit = {
                annotations: {
                    position: "back",
                },
                dataLabels: {
                    enabled: false,
                },
                chart: {
                    type: "bar",
                    height: 300,
                },
                fill: {
                    opacity: 1,
                },
                series: [
                    {
                        name: "Total Pendanaan",
                        data: data.barChart.data,
                    },
                ],
                colors: "#435ebe",
                xaxis: {
                    categories: data.barChart.categories,
                    title: { text: "Months" },
                },
                yaxis: {
                    title: { text: "Pendanaan (Rp)" },
                },
            };
            const chartProfileVisit = new ApexCharts(
                document.querySelector("#chart-profile-visit"),
                optionsProfileVisit
            );
            chartProfileVisit.render();

            const optionsVisitorsProfile = {
                series: data.pieChart.data,
                labels: data.pieChart.labels,
                colors: ["#435ebe", "#55c6e8", "#e83e8c", "#20c997", "#ffc107"],
                chart: {
                    type: "donut",
                    width: "100%",
                    height: 350,
                },
                legend: {
                    position: "bottom",
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "30%",
                        },
                    },
                },
            };
            const chartVisitorsProfile = new ApexCharts(
                document.querySelector("#chart-visitors-profile"),
                optionsVisitorsProfile
            );
            chartVisitorsProfile.render();
        })
        .catch((error) => console.error("Error fetching data:", error));
});

<template>
    <div class="container">
        <h1>Indicadores</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Earum laudantium, repellat asperiores omnis nemo vero maiores! Ipsam ut tempore dignissimos perspiciatis, dolores rem magnam maiores quas facilis necessitatibus eum dolorem.</p>
        <Bar
            id="indicadores"
            :options="chartOptions"
            :data="chartData"
        />
    </div>
</template>

<script>
    import { Bar } from 'vue-chartjs'
    import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
    ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
    export default {
        name: 'BarChart',
        components: { Bar },
        data() {
            return {
                chartData: {
                    labels: [ 'January', 'February', 'March' ],
                    datasets: [ { data: [40, 20, 12] } ]
                },
                chartOptions: {
                    responsive: true
                }
            }
        }
    }

</script>
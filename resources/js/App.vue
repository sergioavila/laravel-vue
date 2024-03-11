<template>
    <div class="container">
       <div class="info my-5">
        <h1>UF Chile</h1>
        <p>Elige un rango de fechas para mostrar los valores de la UF entre esos valores.</p>
       </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text">Desde</span>
                    <input type="date" class="form-control" aria-label="Desde" :max="today" min="1990-01-01" :value="from" @input="from = $event.target.value">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text">Hasta</span>
                    <input type="date" class="form-control" aria-label="Hasta" :max="today" min="1990-01-01" v-model="to">
                </div>
            </div>
            <div class="col-12" v-if="errorMessage">
                <div class="alert alert-danger" role="alert">
                    {{ errorMessage }}
                </div>
            </div>
        </div>
        <Bar
            id="indicadores"
            :options="chartOptions"
            :data="chartData"
        />
    </div>
</template>

<script>
    import { Bar } from 'vue-chartjs'
    import { mapState, mapActions } from 'vuex'
    import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
    ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
    const today = new Date()

    export default {
        name: 'BarChart',
        components: {
            Bar
        },
        data() {
            return {
                chartData: {
                    labels: [ 'January', 'February', 'March' ],
                    datasets: [ { data: [40, 20, 12] } ]
                },
                chartOptions: {
                    responsive: true
                },
                today: today.toISOString().split('T')[0],
                from : today.toISOString().split('T')[0],
                to : today.toISOString().split('T')[0],
                errorMessage : ''
            }
        },
        computed: {
            // Mapea el estado `data` del store a la propiedad computada `data`
            ...mapState(['valoresUF'])
        },
        watch: {
            //validar que la fecha de inicio no sea mayor a la fecha de término
            from(newFrom, oldFrom) {
                if (newFrom > this.to) {
                    this.errorMessage = 'La fecha de inicio no puede ser mayor a la fecha de término.'
                } else {
                    this.errorMessage = ''
                }
                console.log(this.valoresUF)
            },
            to(newTo, oldTo) {
                if (this.from > newTo) {
                    this.errorMessage = 'La fecha de término no puede ser menor a la fecha de inicio.'
                } else {
                    this.errorMessage = ''
                }
            }
        },
        methods: {
            ...mapActions(['fetchData'])
        },
        created() {
            this.fetchData(this.from, this.to)
            console.log(this.valoresUF)
        }
    }
</script>
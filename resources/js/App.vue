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
        <Line
            id="indicadores"
            :options="chartOptions"
            :data="chartData"
        />
    </div>
</template>

<script>
    import { Line } from 'vue-chartjs'
    import { mapGetters, mapActions } from 'vuex'
    import { Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend } from 'chart.js'
    ChartJS.register(CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend)
    const today = new Date()

    export default {
        name: 'LineChart',
        components: {
            Line
        },
        data() {
            return {
                chartData: {
                    labels: [ ],
                    datasets: [ { data: [] } ]
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
            ...mapGetters(['getValoresUF'])
        },
        watch: {
            //validar que la fecha de inicio no sea mayor a la fecha de término
            from(newFrom) {
                if (newFrom > this.to) {
                    this.errorMessage = 'La fecha de inicio no puede ser mayor a la fecha de término.'
                } else {
                    this.errorMessage = ''
                    this.createChartData(this.getValoresUF)
                }
            },
            to(newTo) {
                if (this.from > newTo) {
                    this.errorMessage = 'La fecha de término no puede ser menor a la fecha de inicio.'
                } else {
                    this.errorMessage = ''
                    this.createChartData(this.getValoresUF)
                }
            }
        },
        methods: {
            ...mapActions(['fetchData']),
            //remove dots from string and convert to number
            formatMoney(value) {
                return Number(value.replace(/\./g, '').replace(',', '.'))
            },
            //create chartData method
            createChartData(dataUF){
                let dates = {
                    from: this.from,
                    to: this.to
                }
                this.fetchData(dates)
                this.chartData = {
                    labels: dataUF.map(item => item.date),
                    //agrega datos al gráfico
                    datasets: [
                        {
                            label: 'Valor UF',
                            data: dataUF.map(item => this.formatMoney(item.value)),
                            //agregar formato de peso chileno al tooltip 
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        var label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += context.parsed.y.toLocaleString('es-CL', { style: 'currency', currency: 'CLP' });
                                            label += ' CLP';
                                        }
                                        return label;
                                    }
                                }
                            },
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }
                    ]
                }
            }
        }
    }
</script>
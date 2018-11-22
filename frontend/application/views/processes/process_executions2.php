<div id="app" v-cloak>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Ejecuciones del proceso </h4>
            <div class="card-description">
                <div class="actions">
                    <button class="btn btn-primary" @click="run">Iniciar nueva ejecución</button>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <textarea cols="50" rows="20" v-model="input">

                        </textarea>
                    </div>
                    <div class="col-lg-6">
                        Progreso de ejecución:

                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar"
                                 v-bind:style="'width: '+progressLoad + '%'"
                                 :aria-valuenow="progressLoad" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                </div>

                <div class="row" v-if="output">
                    <div class="col-lg-12">
                        Resultados
                    </div>
                    <div class="col-lg-6">
                         <textarea cols="50" rows="20">{{output}}</textarea>
                    </div>
                    <div class="col-lg-6">
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script
        src="//cdnjs.cloudflare.com/ajax/libs/vue/2.1.6/vue.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script>
    new Vue({
        el: "#app",
        data() {
            return {
            }
        },
        methods: {
            run: function () {
                var self = this;
                var self = this;
                var data = new FormData();
                data.append('request', JSON.stringify(this.input));
                axios.post('/processes/execute/<?php echo $process_id;?>')
                    .then(function (res) {
                        debugger
                        if (res.data.response) {
                            self.output = res.data.content;
                        }
                        /* if (res.data.result) {
                            if (res.data.horas.length > 0) {
                                self.message = null;
                                self.horarios_disponibles = res.data.horas;
                            } else {
                                self.message = "No hay horarios para la hora seleccionada";
                            }
                            self.loading_horario = false;
                            self.progressLoad = 100;


                        } else {
                            alert("Error al recuperar horas");
                            self.loading_horario = false;
                        } */
                    });


            }
        }
    });
</script>
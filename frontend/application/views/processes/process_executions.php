<div class="col-lg-12 grid-margin">
    <div id="app" class="card">
        <div class="card-body">
            <h4 class="card-title">Ejecuciones del proceso: Lematización y corrección ortografica 1</h4>
            <div class="card-body">
                <button @click="run()">Ejecutar</button>
                <button @click="update()">Actualizar</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            UUID
                        </th>

                        <th>
                            Progreso
                        </th>
                        <th>
                            Tiempo transcurrido desde inicio
                        </th>
                        <th>
                            Acciones
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="font-weight-medium">
                            <?php echo uniqid(); ?>
                        </td>
                        <td class="text-danger">En ejecución
                            <i class="mdi mdi-play-protected-content"></i>
                        </td>
                        <td>
                            5 dias, 7 minutos
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Operaciones">
                                <a title="Matar ejecución" href="#" class="btn btn-outline-secondary">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/vue/2.1.6/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                input: <?php echo $process_id ?>
            }
        },
        methods: {
            run: function () {
                alert("Ejecutando...");
                var self = this;
                var data = new FormData();
                data.append('request', this.input);
                axios.post('/processes/execute', data)
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
            },
            update: function () {
                
            }
        }
    })
</script>
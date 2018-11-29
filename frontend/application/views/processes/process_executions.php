<div class="col-lg-12 grid-margin">
    <div id="app">
        <div class="row">
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-body">
                        <pre>{{treeExecution | json}}</pre>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">

                    <div class="card-body">
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-lg"
                                    @click="run(<?php echo $process_id ?>)">
                                <img src="/assets/img/play-48.png" style="height: 24px; width: 24px"/>Ejecutar
                            </button>

                            <button type="button" class="btn btn-outline-primary btn-lg" @click="update()">
                                <img src="/assets/img/update-48.png" style="height: 24px; width: 24px"/>Actualizar
                            </button>
                        </div>
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
                                    Momento de inicio
                                </th>
                                <th>
                                    Acciones
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($execution_table) { ?>
                                <?php foreach ($execution_table as $item) { ?>
                                    <tr>
                                        <td>
                                            <a href="/processes/">
                                                <?php echo $item['exe_id'] ?>
                                            </a>
                                        </td>
                                        <td><?php if ($item['exe_status'] == 'processing') { ?>
                                                <img src="/assets/img/loading.gif"/>
                                            <?php } else if ($item['exe_status'] == 'terminado') { ?>
                                                <img src="/assets/img/icon-ready.png"/>
                                            <?php } ?>

                                        </td>
                                        <td><?php
                                            echo $item['exe_created_at'] ?></td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Operaciones">
                                                <button title="Ver resultados" @click="selectExecution('<?php echo $item['exe_id'] ?>')">
                                                    <i class="mdi mdi-view-week"></i>
                                                </button>
                                                <!--
                                                <a title="Matar ejecución"
                                                   href="/processes/destroy_ex/<?php echo $item['exe_id'] ?>"
                                                   class="btn btn-outline-secondary">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                                -->
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                id: <?php echo $process_id ?>,
                input: <?php echo $process_id ?>,
                toast: null,
                treeExecution: {}
            }
        },
        created() {
            this.toast = swal.mixin({
                toast: true,
                type: 'success',
                title: 'Signed in successfully',
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            })
        },
        methods: {
            run: function (id) {
                var self = this;
                this.toast({type: 'info', title: 'Iniciando ejecución de proceso ...'});
                axios.post('/processes/execute/' + id)
                    .then(function (arg) {
                        self.toast({type: 'info', title: 'Procesando ejecución ...'});
                        location.reload();
                    });
            },
            update: function () {
                var self = this;
                this.toast({type: 'info', title: 'Actualizando estados de proceso ...'});
                axios.post('/processes/update_table/')
                    .then(function (arg) {
                        self.toast({type: 'info', title: '¡Estados de proceso actualizados!'});
                        if (arg.data) {
                            location.reload();
                        }
                        else {
                            self.toast({type: 'info', title: 'No hay estados nuevos'});
                        }
                    });
            },
            selectExecution: function (execution_id) {
                var self = this;
                 axios.get('/processes/parse-to-json-for-view/' + this.id)
                    .then(function (r) {
                        debugger;
                        self.treeExecution = r.data.input;
                    })
            }
        }
    })
</script>
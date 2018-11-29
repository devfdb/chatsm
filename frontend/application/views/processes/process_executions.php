
<div class="col-lg-12 grid-margin">
    <div id="app" class="card">
        <div class="card-body">
            <h2 class="card-title">Proceso <?php echo $process_name?></h2>
            <div class="card-body">
                <button @click="run(<?php echo $process_id?>)">Ejecutar</button>
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
                        <td><?php echo $item['exe_status'] ?></td>
                        <td><?php
                            echo $item['exe_created_at'] ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Operaciones">
                                <a title="Matar ejecución" href="/processes/destroy_ex/<?php echo $item['exe_id'] ?>" class="btn btn-outline-secondary">
                                    <i class="mdi mdi-delete"></i>
                                </a>
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
            run: function (id) {
                swal("Ejecutando...");
                var self = this;
                axios.post('/processes/execute/'+id)
                    .then(function (arg) {
                        swal({
                            title: 'Enviado',
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        })
                    });
            },
            update: function () {
                var self = this;
                swal('actualizando');
                axios.post('/processes/update_table/')
                    .then(function (arg) {
                        debugger;
                        if (arg.data) {
                            swal({
                                title: 'Se han actualizado los campos',
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                            })
                        }
                        else {
                            swal({
                                title: "No hay datos nuevos",
                                type: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            })
                        }
                    });
            }
        }
    })
</script>
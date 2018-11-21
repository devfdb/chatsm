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
            <a href="/processes" class="btn btn-primary">Crear nueva ejecución</a>
            <a href="/processes" class="btn btn-primary">Actualizar ejecuciones</a>
        </div>
    </div>
</div>

<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                
            }
        },
        methods: {
            run: function () {
                alert("Ejecutando")
            },
            update: function () {
                
            }
        }
    })
</script>
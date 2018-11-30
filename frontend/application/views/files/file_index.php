<div id="app" class="card">
    <div class="card-body">
        <h4 class="card-title">Archivos</h4>
        <div class="card-description">
            <div class="actions">
            <a class="btn btn-primary" href="/files/create?path=<?php echo $current_dir_id?>">Subir archivo</a>
        </div>
        </p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>

                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Tipo de archivo
                    </th>
                    <th>
                        Fecha de creación
                    </th>
                    <th>
                        Operaciones
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($current_dir_id != '') {
                ?>
                <tr>
                    <td width="50px">
                        <i class="mdi <?php
                            echo 'mdi-folder';
                        ?>"></i>
                    </td>
                    <td><a href="/files?path=<?php
                        echo $last_dir; ?>">..</a></td>
                    <td><?php echo "carpeta" ?></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php } ?>
                <?php if ($file_list) { ?>
                    <?php foreach ($file_list as $item) { ?>
                        <tr>
                            <td width="50px">
                                <i class="mdi <?php
                                if($item['fil_file_format'] == 'dir'){
                                    echo 'mdi-folder';

                                }else{
                                    echo 'mdi-file';

                                }
                                ?>"></i>
                            </td>
                            <td>
                                <?php
                                if ($item['fil_file_format'] == 'image') {
                                    ?>
                                    <a class="example-image-link" data-lightbox="example-1"><img class="example-image" src=<?php echo 'files//image//'.$item['fil_url'] ?>><?php echo $item['fil_filename']?></a>
                                <?php
                                }
                                else if ($item['fil_file_format'] == 'csv') {
                                    ?>
                                    <strong><?php echo $item['fil_filename']?></strong>
                                    <?php
                                }
                                else if ($item['fil_file_format'] == 'folder') {
                                ?>
                                <a href="/files?path=<?php
                                echo $item['fil_id']; ?>"><?php echo $item['fil_filename'] ?></a>
                                <?php
                                }
                                else {
                                    ?>
                                    <?php echo $item['fil_filename']?>
                                <?php
                                }
                                ?>

                            </td>


                            <td><?php echo  $item['fil_file_format'] ?></td>
                            <td><?php echo $item['fil_created_at'] ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Operaciones">
                                    <a title="Editar instancia"
                                       href="/files/edit/<?php echo $item['fil_id'] ?>"
                                       class="btn btn-outline-secondary"
                                    >
                                        <i class="mdi mdi-table-edit"></i>
                                    </a>
                                    <button title="Eliminar archivo"
                                       @click="destroy(<?php echo $item['fil_id'] ?>);"
                                       class="btn btn-outline-secondary">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/vue/2.1.6/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: function () {
                return {
                    input: <?php echo $current_dir_id ?>;
                }
            },
            methods: {
                destroy: function (id) {
                    debugger;
                    swal("Eliminando...");
                    var self = this;
                    axios.post('/files/destroy/'+id)
                        .then(function (arg) {
                            if (arg) {
                                swal({
                                    title: 'Eliminado',
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
                                    title: 'Error de eliminacion',
                                    type: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.value) {
                                        location.reload();
                                    }
                                })
                            }
                        });
                    }
                }
            }
        })
    </script>
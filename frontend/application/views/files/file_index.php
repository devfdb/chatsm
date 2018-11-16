<div class="card">
    <div class="card-body">
        <h4 class="card-title">Archivos</h4>
        <div class="card-description">
            <div class="actions">
            <a class="btn btn-primary" href="/files/create">Subir archivo</a>
        </div>
        </p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Tipo
                    </th>
                    <th>
                        Fecha
                    </th>

                    <th>
                        Operaciones
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php if ($list_files) { ?>
                    <?php foreach ($list_files as $item) { ?>
                        <tr>
                            <td width="50px">
                                <i class="mdi <?php
                                if($item['filetype'] == 'dir'){
                                    echo 'mdi-folder';

                                }else{
                                    echo 'mdi-file';

                                }
                                ?>"></i>
                            </td>

                            <td><a href="/files?path=<?php echo $current_dir.$item['filename']; ?>"><?php echo $item['filename'] ?></a></td>
                            <td><?php echo  $item['filetype'] ?></td>
                            <td>
                            <!--
                                <div class="btn-group" role="group" aria-label="Operaciones">
                                    <a title="Editar instancia"
                                       href="/task-instances/edit/<?php echo $item['ins_id'] ?>"
                                       class="btn btn-outline-secondary">
                                        <i class="mdi mdi-table-edit"></i>
                                    </a>
                                    <a title="Eliminar instancia"
                                       href="/task-instances/destroy/<?php echo $item['ins_id'] ?>"
                                       class="btn btn-outline-secondary">
                                        <i class="mdi mdi-delete"></i>
                                    </a>
                                </div>
                            -->
                            </td>


                        </tr>
                    <?php }
                } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

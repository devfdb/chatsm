<div class="card">
    <div class="card-body">
        <h4 class="card-title">Procesos</h4>
        <div class="card-description">
            <div class="actions">
            <a class="btn btn-primary" href="/processes/create">Crear nuevo proceso</a>
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
                        Entrada
                    </th>
                    <th>
                        Autor
                    </th>
                    <th>
                        Fecha de creación
                    </th>
                    <th>
                        Última modificación
                    </th>
                    <th>
                        Operaciones
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php if ($process_table) { ?>
                    <?php foreach ($process_table as $item) { ?>
                        <tr>
                            <td><?php echo $item['prc_name'] ?></td>
                            <td><?php echo $item['prc_input'] ?></td>
                            <td><?php echo $item['prc_owner'] ?></td>
                            <td><?php echo $item['prc_created_at'] ?></td>
                            <td><?php echo $item['prc_last_modified'] ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Operaciones">
                                    <a title="Ejecuciones del proceso"
                                       href="/processes/executions/<?php echo $item['prc_id'] ?>"
                                       class="btn btn-outline-secondary">
                                        <i class="mdi mdi-run"></i>
                                    </a>
                                     <a title="Editar proceso"
                                       href="/processes/edit/<?php echo $item['prc_id'] ?>"
                                       class="btn btn-outline-secondary">
                                        <i class="mdi mdi-table-edit"></i>
                                    </a>
                                    <!-- <a title="Eliminar proceso"
                                       href="/processes/destroy/<?php echo $item['prc_id'] ?>"
                                       class="btn btn-outline-secondary">
                                        <i class="mdi mdi-delete"></i>
                                    </a> -->
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

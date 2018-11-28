<div class="card">
    <div class="card-body">
        <h4 class="card-title">Instancias</h4>
        <div class="card-description">
            <div class="actions">
            <a class="btn btn-primary" href="/task-instances/create">CREAR NUEVO</a>
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
                <?php if ($instance_table) { ?>
                    <?php foreach ($instance_table as $item) { ?>
                        <tr>
                            <td><?php echo $item['ins_name'] ?></td>
                            <td><?php #echo #$type_table[$item['ins_type_id']]
                                // TODO: Esto no funciona asi con posicion del array, si no segun el valor del key !!!! ?></td>
                            <td><?php echo $user_table[$item['ins_owner']] ?></td>
                            <td><?php echo $item['ins_owner'] ?></td>
                            <td><?php echo $item['ins_last_modified'] ?></td>
                            <td>
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
                            </td>
                        </tr>
                    <?php }
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

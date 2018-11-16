<div class="card">
    <div class="card-body">
        <h4 class="card-title">Archivos del proyecto</h4>
        <div class="card-description">
            <div class="actions">
            <a class="btn btn-primary" href="/task-instances/create">AGREGAR NUEVO</a>
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
                        Autor
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
                            <td><?php echo $type_table[$item['ins_type_id']] ?></td>
                            <td><?php echo $item['ins_creation_date'] ?></td>
                            <td><?php echo $item['ins_creator_id'] ?></td>
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

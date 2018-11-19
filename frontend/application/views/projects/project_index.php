<div class="card">
    <div class="card-body">
        <h4 class="card-title">Archivos del proyecto</h4>
        <div class="card-description">
            <div class="actions">
            <a class="btn btn-primary" href="/projects/create">AGREGAR NUEVO</a>
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
                        Descripción
                    </th>
                    <th>
                        Autor
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
                <?php if ($project_table) { ?>
                    <?php foreach ($project_table as $item) { ?>
                        <tr>
                            <td><?php echo $item['prj_name'] ?></td>
                            <td><?php echo $item['prj_description'] ?></td>
                            <td><?php echo $item['prj_creator'] ?></td>
                            <td><?php echo $item['prj_created_at'] ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Operaciones">
                                    <a title="Editar proyecto"
                                       href="/projects/edit/<?php echo $item['prj_id'] ?>"
                                       class="btn btn-outline-secondary">
                                        <i class="mdi mdi-table-edit"></i>
                                    </a>
                                    <a title="Eliminar proyecto"
                                       href="/projects/destroy/<?php echo $item['prj_id'] ?>"
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

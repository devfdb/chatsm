<table style="width:100%">
    <a href="/task-instances/create">CREAR NUEVO
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Tipo</th>
        <th>Fecha</th>
        <th>Autor</th>
        <th></th>
        <th></th>
    </tr>
    <?php if($instance_table) {?>
        <?php foreach($instance_table as $item) {?>
        <tr>
            <td><?php echo $item['ins_id'] ?></td>
            <td><?php echo $item['ins_name'] ?></td>
            <td><?php echo $type_table[$item['ins_type_id']] ?></td>
            <td><?php echo $item['ins_creation_date'] ?></td>
            <td><?php echo $item['ins_creator_id'] ?></td>
            <td><a href="/task-instances/edit/<?php echo $item['ins_id'] ?>">Editar</td>
            <td><a href="/task-instances/destroy/<?php echo $item['ins_id'] ?>">Eliminar</td>
        </tr>
    <?php } } ?>
</table>
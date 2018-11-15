<table style="width:100%">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Tipo</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach($instance_table as $item) {
        ?>
        <tr>
            <td><?php echo $item['ins_id'] ?></td>
            <td><?php echo $item['ins_name'] ?></td>
            <td><?php echo $type_table[$item['ins_type_id']] ?></td>
            <td><a href="/task-instances/edit/<?php echo $item['ins_id'] ?>">Editar</td>
            <td><a href="/task-instances/destroy/<?php echo $item['ins_id'] ?>">Eliminar</td>
        </tr>
    <?php } ?>
</table>
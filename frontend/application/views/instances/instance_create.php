<h1>Creación de instancia</h1>


<?php echo form_open(base_url().'instances/create', 'class="email" id="myform"');?>

<?php echo form_label('nombre','name') ?>
<?php echo form_input('name') ?>
<?php echo form_error('name'); ?>

<?php echo form_dropdown('shirts', $list_types, 'large'); ?>

<?php echo form_submit('submit','crear instancia') ?>

<?php echo form_close();?>
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Editar instancia</h4>
            <?php echo form_open(base_url() . 'task-instances/edit/'.$instance['ins_id'], array('class', 'email')); ?>
            <p class="card-description">
                Actualiza la instancia a partir de la configuración del modelo.
            </p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <?php echo form_label('Nombre', 'name', array('class' => 'col-sm-3 col-form-label')) ?>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'name', 'value' => $instance['ins_name'], 'class' => 'form-control')) ?>
                        </div>
                        <?php echo form_error('name'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tipo</label>

                        <div class="col-sm-9">
                            <?php echo form_dropdown('type_id', $list_types, $instance['ins_type_id'], array('class'=>'form-control')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php echo form_submit('submit', 'Actualizar instancia', array('class'=>'btn btn-success mr-2')) ?>
                <button class="btn btn-light">Cancelar</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

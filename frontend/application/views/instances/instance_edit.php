<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Actualizar instancia</h4>
            <?php echo form_open(base_url() . 'instances/edit', array('class', 'email')); ?>
            <p class="card-description">
                Edita una instancia a partir de su identificador.
            </p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <?php echo form_label('id', 'name', array('class' => 'col-sm-3 col-form-label')) ?>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'name', 'class' => 'form-control')) ?>
                        </div>
                        <?php echo form_error('name'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tipo</label>

                        <div class="col-sm-9">
                            <?php echo form_dropdown('types', $list_types, 'large', array('class'=>'form-control')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php echo form_submit('submit', 'Crear instancia', array('class'=>'btn btn-success mr-2')) ?>
                <button class="btn btn-light">Cancelar</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
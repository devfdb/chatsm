<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Crear instancia</h4>
            <?php echo form_open(base_url() . 'projects/create', array('class', 'email')); ?>
            <p class="card-description">
                Crea una instancia a partir de la configuración de un modelo.
            </p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <?php echo form_label('Nombre', 'name', array('class' => 'col-sm-3 col-form-label')) ?>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'name', 'class' => 'form-control')) ?>
                        </div>
                        <?php echo form_error('name'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <?php echo form_label('Descripción', 'description', array('class' => 'col-sm-3 col-form-label')) ?>
                        <div class="col-sm-9">
                            <?php echo form_input(array('name' => 'description', 'class' => 'form-control')) ?>
                        </div>
                        <?php echo form_error('description'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php echo form_submit('submit', 'Crear proyecto', array('class'=>'btn btn-success mr-2')) ?>
                <a href="/projects/index" class="btn btn-light">Cancelar</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

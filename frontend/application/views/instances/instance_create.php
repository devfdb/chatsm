<div class="col-12 grid-margin">

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Bootstrap Maxlength</h4>
            <div class="form-group row">
                <div class="col-lg-3">
                    <label class="col-form-label">Default usage</label>
                </div>
                <div class="col-lg-8">
                    <input class="form-control" maxlength="25" name="defaultconfig" id="defaultconfig" type="text" placeholder="Type Something.."> </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-3">
                    <label class="col-form-label">Few options</label>
                </div>
                <div class="col-lg-8">
                    <input class="form-control" maxlength="20" name="defaultconfig-2" id="defaultconfig-2" type="text" placeholder="Type Something.."> </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-3">
                    <label class="col-form-label">All the options</label>
                </div>
                <div class="col-lg-8">
                    <input class="form-control" maxlength="10" name="defaultconfig-3" id="defaultconfig-3" type="text" placeholder="Type Something.."> </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-3">
                    <label class="col-form-label">Text Area</label>
                </div>
                <div class="col-lg-8"> <textarea id="maxlength-textarea" class="form-control" maxlength="100" rows="2" placeholder="This textarea has a limit of 100 chars."></textarea> </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Crear instancia</h4>
            <?php echo form_open(base_url() . 'task-instances/create', array('class', 'email')); ?>
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
                        <label class="col-sm-3 col-form-label">Tipo</label>

                        <div class="col-sm-9">
                            <?php echo form_dropdown('type_id', $list_types, 'large', array('class'=>'form-control')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php echo form_submit('submit', 'Crear instancia', array('class'=>'btn btn-success mr-2')) ?>
                <a href="/task-instances/index" class="btn btn-light">Cancelar</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

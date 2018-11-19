<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Define un proyecto para trabajar</h4>
            <?php echo form_open(base_url() . 'projects/define', array('class', 'email')); ?>
            <p class="card-description">
                Selecciona un proyecto para trabajar
            </p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <?php echo form_label('Proyecto', 'project_id', array('class' => 'col-sm-3 col-form-label')) ?>
                        <div class="col-sm-9">
                            <?php echo form_dropdown('project_id', $list_projects, $project_id, array('class'=>'form-control')) ?>
                        </div>
                        <?php echo form_error('project_id'); ?>
                    </div>
                </div>

            </div>
            <div class="row">
                <?php echo form_submit('submit', 'Seleccionar proyecto', array('class'=>'btn btn-success mr-2')) ?>
                <button class="btn btn-light">Crear nuevo proyecto</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

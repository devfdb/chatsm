<div class="col-12 grid-margin">



    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Crear proceso</h4>
            <?php echo form_open(base_url() . 'processes/create', array('class', 'email')); ?>
            <p class="card-description">
                Crea un nuevo proyecto
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
                        <label class="col-sm-3 col-form-label">Archivo de entrada</label>

                        <div class="col-sm-9">
                            <?php echo form_dropdown('input_id', $file_list, null, array('class'=>'form-control')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php echo form_submit('submit', 'Crear instancia', array('class'=>'btn btn-success mr-2')) ?>
                <a href="/processes" class="btn btn-light">Cancelar</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php $this->load->view('layout/display'); ?>

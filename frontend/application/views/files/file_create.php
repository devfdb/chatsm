<?php $this->load->view('layout/display'); ?>
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">File Uploader</h4>
            <?php echo form_open_multipart(base_url() . 'files/create');?>
            <p class="card-description">
                Sube un archivo.
            </p>
            <div class="row">

                <input type="file" name="userfile" size="20" />
                <input type="submit" value="Subir" />
                </form>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php $this->load->view('layout/display'); ?>
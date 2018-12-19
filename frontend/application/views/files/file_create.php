<?php
    $this->load->view('layout/display');
    $message = $this->session->flashdata('message');
?>

<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">File Uploader</h4>
            <?php echo validation_errors(); ?>
            <?php echo form_open_multipart(base_url() . 'files/create');?>
            <p class="card-description">
                Sube un archivo.
            </p>
            <div class="row">
                <input type="file" name="userfile" size="20" />
                <input type="hidden" name="dir_id" value=<?php echo $curr_dir_id ?>/>
                <input class="btn btn-light" type="submit" value="Subir" />
                <a href="<?php echo '/files?path='.$curr_dir_id ?>" class="btn btn-light">Volver</a>
                </form>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php $this->load->view('layout/display'); ?>

<script>
    debugger;
    var message = <?php echo $message; ?>;
    if (message && message.text)  {
        swal(message);
    }
</script>

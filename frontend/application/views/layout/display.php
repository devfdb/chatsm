
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.0/dist/sweetalert2.all.min.js"></script>
<script>

var message = <?php echo isset($message) ? $message : 'null'; ?>;
if(message){
    const toast = swal.mixin({
      toast: true,
      position: 'top-bottom',
      showConfirmButton: false,
      timer: 3000
    });

    toast({
      type: message.type,
      title: message.title
    })
}
</script>
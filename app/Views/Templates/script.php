<script>
    function method_url(controller, method) {
        const base_url = "<?= base_url(); ?>" + controller + '/' + method;
        return base_url;
    }
</script>
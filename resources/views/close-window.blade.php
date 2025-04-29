echo "
<script>
    window.addEventListener('beforeunload', function () {
        window.opener.postMessage('closed', '*');
    });
    window.close();
</script>";

<script src={{ asset("../assets/libs/summernote-bs4.min.js"  )}} ></script>
<script type="text/javascript">
$('#summernote-basic').summernote({
    placeholder: 'Write something...',
    height: 230,
    maximumImageFileSize: 500*1024, // 500 KB
    callbacks: {
        // fix broken checkbox on link modal
        onInit: function onInit(e) {
            var editor = $(e.editor);
            editor.find('.custom-control-description').addClass('custom-control-label').parent().removeAttr('for');
        }
    }
});
</script>

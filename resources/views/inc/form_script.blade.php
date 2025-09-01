<script type="text/javascript">
    $(document).ready(function () {
        $('body').find('input, select, textarea').filter('[required]:visible').parent('div .mb-5').find('label:not(.form-check-label)').append('<span style="color: red;"> *</span>');
        $('body').find('input, select, textarea').filter('[required]:visible').parent('div').parent('div .mb-5').find('label:not(.form-check-label)').append('<span style="color: red;"> *</span>');
        $('body').find('input, select, textarea').filter('[required]:visible').parent('div .input-group').parent('div').parent('div .mb-5').find('label:not(.form-check-label)').append('<span style="color: red;"> *</span>');
    });
</script>

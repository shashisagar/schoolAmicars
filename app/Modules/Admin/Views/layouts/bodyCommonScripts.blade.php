<!-- Javascripts -->
<script src="/assets/plugins/jquery/jquery-2.1.3.min.js"></script>
<script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/plugins/pace-master/pace.min.js"></script>
<script src="/assets/plugins/jquery-blockui/jquery.blockui.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="/assets/plugins/switchery/switchery.min.js"></script>
<script src="/assets/plugins/uniform/jquery.uniform.min.js"></script>
<script src="/assets/plugins/offcanvasmenueffects/js/classie.js"></script>
<script src="/assets/plugins/waves/waves.min.js"></script>
<script src="/assets/plugins/select2/js/select2.js"></script>

{{--FOR UI-NOTIFICATIONS--}}
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/js/pages/notifications.js"></script>
<script src="/assets/js/custom.js"></script>

<script>
    $(document).ready(function () {
        //FOR UI-NOTIFICATIONS
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "slideDown",
            "hideMethod": "slideUp"
        };
        @if(session('msg')!='')
                toastr["{{session('status')}}"]("{{session('msg')}}");
        @endif

    });
</script>
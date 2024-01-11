    <!-- CoreUI and necessary plugins-->
    <script src="{{asset('admin/vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
    <script src="{{asset('admin/vendors/simplebar/js/simplebar.min.js')}}"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <!-- Add this to your HTML file -->
    <script>
    @if(session('success'))
        new Noty({
            text: '{{ session('success') }}',
            type: 'success',
            timeout: 3000, // Duration of the notification
            layout: 'topRight' // Notification position
        }).show();
    @endif

    @if(session('error'))
        new Noty({
            text: '{{ session('error') }}',
            type: 'error',
            timeout: 3000, // Duration of the notification
            layout: 'topRight' // Notification position
        }).show();
    @endif
</script>

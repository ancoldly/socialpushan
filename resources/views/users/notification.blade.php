@if (session('notification'))
<script>
    swal("Message", "{{ Session::get('notification') }}", 'success', {
        button: true,
        button: "OK",
        width: 300,
        timer:1000,
        dangerMode:true,
    })
</script>
@endif


@if (session('error'))
    <script>
        swal("Error", "{{ Session::get('error') }}", 'error', {
            button: true,
            button: "OK",
            width: 300,
            timer: 1000,
            dangerMode: false,
        });
    </script>
@endif

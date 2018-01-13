<script>
    // Initialize DataTable
    $(document).ready(function () {
        $('#DataTable').DataTable();
    });

    // Block user

    $(function () {
        $("button[name='user_action']").on('click', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ url('/') }}" + $(this).data('url'),
                data: {id_str: $(this).data('userid'), screen_name: $(this).data('userscreenname')},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    alert(data['msg']);
                },
                error: function (data) {
                    console.log('Unable perform this action!');
                }
            });
        });
    });

    // Linkify url's

    $('.linkified').linkify({
        target: "_blank"
    });
</script>
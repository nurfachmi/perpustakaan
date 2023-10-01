<table class="table table-bordered" id="{{ $tableId }}" width="100%" cellspacing="0">
    <thead>
        <tr>

            @foreach ($tableHeaders as $head)
                <th>{{ $head }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {

            const table = $("#{!! $tableId !!}")
            const url = "{!! $getDataUrl !!}";
            const columns = @json($tableColumns);

            console.log(url);

            table.DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns: columns,
            });


        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });




        function softDelete(e) {

            const url = $(e).data('url')
            const name = $(e).data('name') ?? ''
            const redirect = $(e).data('redirect')

            Swal.fire({
                title: name,
                text: 'Are you sure to delete this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    cancelButton: 'btn btn-light waves-effect',
                    confirmButton: 'btn btn-primary waves-effect waves-light'
                },
                preConfirm: (e) => {
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            resolve();
                        }, 50);
                    });
                }
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            _method: "DELETE"
                        },
                        url: url,
                        success: function(response) {
                            toastMessage("success", response.msg)
                            setTimeout(function() {
                                window.location = redirect;
                            }, 1000)
                        },
                        error: function(response) {
                            var err = JSON.parse(response.responseText);
                            toastMessage("error", err.msg)
                        }
                    })
                }
            })
        }



        function toastMessage(status, msg) {
            Swal.fire({
                "title": msg,
                "text": "",
                "timer": 5000,
                "width": "32rem",
                "padding": "1.25rem",
                "showConfirmButton": false,
                "showCloseButton": true,
                "timerProgressBar": false,
                "customClass": {
                    "container": null,
                    "popup": null,
                    "header": null,
                    "title": null,
                    "closeButton": null,
                    "icon": null,
                    "image": null,
                    "content": null,
                    "input": null,
                    "actions": null,
                    "confirmButton": null,
                    "cancelButton": null,
                    "footer": null
                },
                "toast": true,
                "icon": status,
                "position": "top-end"
            })

        }
    </script>
@endpush

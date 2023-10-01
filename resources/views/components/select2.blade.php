@push('js')
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script>
        $(".select2").select2({
            theme: "bootstrap",
            placeholder: function() {
                $(this).data('placeholder');
            }
        })
    </script>
@endpush
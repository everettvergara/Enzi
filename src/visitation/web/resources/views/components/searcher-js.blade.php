@if ($searchers > 0)
    @foreach ($searchers as $key => $searcher)
        $(document).ready(function(){  
            $('#'+{!! json_encode($key, JSON_HEX_TAG) !!}+'ModalBtn').on("click", function (e) {
                $('#'+{!! json_encode($key, JSON_HEX_TAG) !!}+'Modal').modal('toggle');
            });

            $('#'+{!! json_encode($key, JSON_HEX_TAG) !!}+'_modal_filter').on("click", function (e) {
                e.preventDefault();
                var column = {!! json_encode($key, JSON_HEX_TAG) !!};
                var model_path = {!! json_encode($searcher['searcher_model_path'], JSON_HEX_TAG) !!};
                var ddl_code = {!! json_encode($searcher['searcher_code'], JSON_HEX_TAG) !!};
                var filters = {!! json_encode($searcher['searcher_filters'], JSON_HEX_TAG) !!};
                var values = $('#'+{!! json_encode($key, JSON_HEX_TAG) !!}+'_modal_form').serializeArray();
                var columns = {!! json_encode($searcher['searcher_columns'], JSON_HEX_TAG) !!};

                $.ajax({
                url:"{{ route('search') }}",
                type:"POST",
                dataType:"html",
                data:{
                    _token: CSRF_TOKEN,
                    column:     column,
                    model_path: model_path,
                    ddl_code: ddl_code,
                    filters: JSON.stringify(filters),
                    values:  JSON.stringify(values),
                    columns: JSON.stringify(columns),
                },
                success:function (data) {
                    $('#'+{!! json_encode($key, JSON_HEX_TAG) !!}+'Modal tbody').empty().html(data);

                    $("."+{!! json_encode($key, JSON_HEX_TAG) !!}+"Modal_result").on("click", function (e) {
                        var id = $(this).data("id");
                        var name = $(this).data("name");
                        $('.'+{!! json_encode($key, JSON_HEX_TAG) !!}).empty();
                        $('.'+{!! json_encode($key, JSON_HEX_TAG) !!}).append('<option value="'+id+'">'+name+'</option>');
                        $('#'+{!! json_encode($key, JSON_HEX_TAG) !!}+'Modal').modal('toggle');
                        return false;
                    });
                },
                error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            });
        });
    @endforeach
@endif


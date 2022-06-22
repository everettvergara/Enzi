@if(count($ddl_conditional)>0){
    @foreach($ddl_conditional as $key => $ddl)
            $(document).ready(function () {
                $({!!json_encode('#'.$ddl['column'], JSON_HEX_TAG) !!}).on('change', function(e) {
                    var values = [];
                    var column = {!! json_encode($key, JSON_HEX_TAG) !!};
                    var model_path = {!! json_encode($ddl['model_path'], JSON_HEX_TAG) !!};
                    var ddl_code = {!! json_encode($ddl['ddl_code'], JSON_HEX_TAG) !!};
                    @foreach ($ddl['dependent-parameters'] as $key_param => $dependent_parameter)
                        values.push({
                            key:{!! json_encode($key_param, JSON_HEX_TAG) !!},
                            @if (isset($ddl_list[$dependent_parameter]))
                                value:$({!! json_encode('#'.$dependent_parameter, JSON_HEX_TAG) !!}).val(),
                            @else
                                value:({!! json_encode($dependent_parameter, JSON_HEX_TAG) !!}),
                            @endif
                        });
                    @endforeach
                    @foreach ($ddl['subdependents'] as $subdependents)
                        $('.'+{!! json_encode($subdependents, JSON_HEX_TAG) !!}).empty();
                        $('.'+{!! json_encode($subdependents, JSON_HEX_TAG) !!}).append('<option value="">Select the ' + {!! json_encode($subdependents, JSON_HEX_TAG) !!}.replace('_id', '').toUpperCase() + '</option>');
                    @endforeach
                    $.ajax({
                        url:"{{ route('conditional-select') }}",
                        type:"POST",
                        dataType: 'json',
                        data:{
                                _token:     CSRF_TOKEN,
                                values:     JSON.stringify(values),
                                column:     column,
                                model_path: model_path,
                                ddl_code:   ddl_code,
                        },
                        success:function (data) {
                            $.each(data.results,function(index,result){
                                var title = document.getElementById(index+'_label').textContent;
                                $('.'+index).empty();
                                $("#"+index).append('<option value="">Select the ' + title + '</option>');
                                $.each(result,function(index_2, result_2){
                                    $('.'+index).append('<option value="'+result_2.id+'">'+result_2.name+'</option>');
                                })
                            })
                        }
                    })
                });
            });
    @endforeach
}
@endif
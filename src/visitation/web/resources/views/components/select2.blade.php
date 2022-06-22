$(document).ready(function(){
    var model_path = {!! json_encode($model_path, JSON_HEX_TAG) !!};
    $('.{{ $column }}').select2({
        placeholder: '{{ $placeholder }}',
        theme: 'bootstrap4',
        ajax: {
            type    : 'POST', 
            url: "{{ route('dynamic-select') }}",
            dataType: 'json',
            delay: 3000,
            data: function(params){
                return{
                    _token: CSRF_TOKEN,
                    search: params.term,
                    model_path: model_path,

                };
            },
            processResults: function(response){
                return{
                    results: response
                };
            },
            cache:true
        }
    });
});
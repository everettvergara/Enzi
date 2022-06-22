@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('head')
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>  
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="card shadow">
    <div class="card-header">
        FILTERS
    </div>
    <div class="card-body">
        <form id="filters">
            @csrf
            <div class="form d-inline">
                <div class="row">
                    @foreach ($filters as $key => $column)
                        @switch(true)
                            @case(array_key_exists($key, $inputs) && ($inputs[$key] == 'text'))
                                @text([
                                    'name'  => $key,
                                    'value' => $prev_output[$key] ?? null,
                                    'col'   => isset($column_num) ? $column_num: null,
                                ])@endtext()
                                @break
                            @case(array_key_exists($key, $inputs) && $inputs[$key] == 'number')
                                @text([
                                    'name'  => $key,
                                    'value' => $prev_output[$key] ?? null,
                                    'col'   => isset($column_num) ? $column_num: null,
                                ])@endtext()
                                @break
                            @case(array_key_exists($key, $inputs) && $inputs[$key] == 'textarea')
                                @text([
                                    'name'  => $key,
                                    'value' => $prev_output[$key] ?? null,
                                    'col'   => isset($column_num) ? $column_num: null,
                                ])@endtext()
                                @break
                            @case(array_key_exists($key, $inputs) && $inputs[$key] == 'select')
                                @select([
                                    'name'      => $key,
                                    'elements'  => $ddl[$key],
                                    'value'     => $prev_output[$key] ?? null,
                                    'col'   => isset($column_num) ? $column_num: null,
                                ])@endselect
                                @break
                            @case(array_key_exists($key, $inputs) && $inputs[$key] == 'select-dynamic')
                                @select([
                                    'name'      => $key,
                                    'elements'  => $ddl[$key],
                                    'value'     => $prev_output[$key] ?? null,
                                    'col'       => isset($column_num) ? $column_num: null,
                                ])@endselect
                                @break
                            @case(array_key_exists($key, $inputs) && $inputs[$key] == 'searcher')
                                @searcher([
                                    'name'      => $key,
                                    'elements'  => $ddl[$key],
                                    'value'     => $prev_output[$key] ?? null,
                                    'col'       => isset($column_num) ? $column_num: null,
                                ])@endsearcher
                                @break
                            @case(array_key_exists($key, $inputs) && $inputs[$key] == 'date')
                                @datefield([
                                    'name' => $key.'_from',
                                    'value' => $prev_output[$key.'_from'],
                                    'col'   => isset($column_num) ? $column_num: null,
                                ])
                                @enddatefield

                                @datefield([
                                    'name' => $key.'_to',
                                    'value' => $prev_output[$key.'_to'],
                                    'col'   => isset($column_num) ? $column_num: null,
                                ])
                                @enddatefield
                                @break
                            @default
                                @text([
                                    'name'  => $key,
                                    'value' => $prev_output[$key] ?? null,
                                    'col'   => isset($column_num) ? $column_num: null,
                                ])@endtext()
                        @endswitch
                    @endforeach
                </div>
                <button type="submit" class="btn btn-secondary form-btn mt-3 search-btn"><i class="far fa-search" style="font-weight: 900"></i> Search</button>
            </div>
        </form>
    </div>
</div>
<div class="card shadow mt-3 mb-3">
    <div class ="card-body" id = "index-body">
            @include('components.index-table', [
                'elements'          => $elements,
                'index_columns'     => $index_columns,
                'route'             => $route,
                'route_param'       => $route_param,
            ])
    </div>
    <div id="modal_section">
    @if ($searchers > 0)
        @foreach ($searchers as $key => $searcher)
            @searcher_modal([
                'key'           => $key,
                'filters'       => $searcher['searcher_filters'],
                'columns'       => $searcher['searcher_columns'],
                'column_num'    => isset($column_num) ? $column_num: null,
                'ddl'           => $searcher_ddl,
            ])
            @endsearcher_modal
        @endforeach
    @endif
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

    $(document).ready(function(){
        $('#filters').on("submit", function (e) {
            e.preventDefault();
            var form = [];
            var dataString = $('#filters').serializeArray();
            $.ajax({
                method: "GET",
                url: "{{ route($route.'.index') }}",
                data: {data: dataString},
                dataType:"html",
                success: function (data){
                    $("#index-body").empty().html(data);
                },
                    error: function (error){
                    console.log(error);
                }
                });
            return false;
        });
    });

    @foreach ($filters as $key => $column)
        @if(array_key_exists($key, $inputs) && $inputs[$key] == 'select-dynamic')
            @foreach ($ddl_dynamic as $key_ddl => $dynamic)
                @if ($key_ddl == $key)
                    @select2([
                        'column'        => $key_ddl,
                        'placeholder'   => $dynamic['placeholder'],
                        'model_path'    => $dynamic['model_path'],
                    ])@endselect2
                @endif
            @endforeach
        @endif
    @endforeach

    @select_conditional([
        'ddl_conditional' => $ddl_conditional,
        'ddl_list'        => $ddl
    ])
    @endselect_conditional

   @searcher_js([
       'searchers' => $searchers
   ])
   @endsearcher_js

    @include('components.searcher-conditional-js', [
        'searcher_conditional' => $searcher_conditional,
        'searcher_ddl'  => $searcher_ddl
    ])


</script>
@endsection
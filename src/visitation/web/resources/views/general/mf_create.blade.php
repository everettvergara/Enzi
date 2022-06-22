@extends('layouts.app')
@section('title'){{ 'CREATE ' . $title }} @endsection
@section('head')
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>  
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{route($route.'.store')}}">
            @csrf

            @field([
            'fields'        => $fields,
            'labels'        => $labels,
            'ddl'           => $ddl,
            'column_num'    => $column_num,
            ])
            @endfield
            
            <button type="submit" class="btn btn-secondary mt-4 btn-user form-btn">
                <i class="fa-solid fa-floppy-disk"></i> Submit
            </button>
        </form>
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

    @foreach ($fields as $key => $column)
        @if(array_key_exists($key, $fields) && $fields[$key] == 'select-dynamic')
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
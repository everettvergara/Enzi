<div class="modal fade" tabindex="-1" id="{{ $key }}Modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                {{ strtoupper(str_replace('_', ' ', str_replace('id', '', $key))) }} SEARCHER
            </div>
            <div class="modal-body">
                <div class="mt-2 mb-2 mr-3 ml-3">
                    <div class="card shadow">
                        <div class="card-header">
                            FILTERS
                        </div>
                        <div class="card-body">
                            <form id="{{ $key }}_modal_form">
                                <div class="form d-inline">
                                    <div class="row">
                                        @foreach ($filters as $filter_key => $filter)
                                            @switch(true)
                                                @case($filter['input'] == 'text')
                                                    @text([
                                                        'name'  => $key.'_modal_'.$filter['column'],
                                                        'label' => strtoupper(str_replace('_', ' ', str_replace('id', '', $filter['column']))),
                                                        'col'   => isset($column_num) ? $column_num: null,
                                                    ])@endtext()
                                                    @break
                                                @case($filter['input'] == 'number')
                                                    @text([
                                                        'name'  => $key.'_modal_'.$filter['column'],
                                                        'label' => strtoupper(str_replace('_', ' ', str_replace('id', '', $filter['column']))),
                                                        'col'   => isset($column_num) ? $column_num: null,
                                                    ])@endtext()
                                                    @break
                                                @case($filter['input'] == 'textarea')
                                                    @text([
                                                        'name'  => $key.'_modal_'.$filter['column'],
                                                        'label' => $filter['column'],
                                                        'col'   => isset($column_num) ? $column_num: null,
                                                    ])@endtext
                                                    @break
                                                @case($filter['input'] == 'select')
                                                    @select([
                                                        'name'      => $key.'_modal_'.$filter['column'],
                                                        'label'     => strtoupper(str_replace('_', ' ', str_replace('id', '', $filter['column']))),
                                                        'elements'  => $ddl[$key.'_modal_'.$filter['column']],
                                                        'col'       => isset($column_num) ? $column_num: null,
                                                    ])@endselect
                                                    @break
                                                @case($filter['input'] == 'select-dynamic')
                                                    @select([
                                                        'name'      => $key.'_modal_'.$filter['column'],
                                                        'label'     => strtoupper(str_replace('_', ' ', str_replace('id', '', $filter['column']))),
                                                        'elements'  => $ddl[$key.'_modal_'.$filter['column']],
                                                        'col'       => isset($column_num) ? $column_num: null,
                                                    ])@endselect
                                                    @break
                                                @case($filter['input'] == 'date')
                                                    @datefield([
                                                        'name' => $key.'_modal_'.$filter['column'],
                                                        'label' => strtoupper(str_replace('_', ' ', $filter['column'])),
                                                        'col'   => isset($column_num) ? $column_num: null,
                                                    ])
                                                    @enddatefield
                                                    @break
                                                @default
                                                    @text([
                                                        'name'  => $key.'_modal_'.$filter['column'],
                                                        'label' => strtoupper(str_replace('_', ' ', str_replace('id', '', $filter['column']))),
                                                        'col'   => isset($column_num) ? $column_num: null,
                                                    ])@endtext()
                                            @endswitch
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-secondary form-btn mt-3 search-btn" id="{{ $key }}_modal_filter"><i class="far fa-search" style="font-weight: 900"></i> Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card shadow mt-3 mb-3">
                        <div class ="card-body">
                            <table class="table table-striped">
                                <thead class="table-light-blue">
                                    <tr>
                                        <td>NO.</td>
                                        @foreach ($columns as $column)
                                            <td>{{  strtoupper($column) }}</td>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @if(isset($elements))
                                         @include('components.searcher-table', [
                                        'key' => $key,
                                        'elements' => $elements,
                                        'columns' => $columns
                                    ])
                                    @endif
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary form-btn" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
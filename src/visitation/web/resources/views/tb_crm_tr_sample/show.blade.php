@extends('layouts.app')
@section('dashboard')SAMPLE @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
            <div class="row">
            @datefield([
                'name' => 'sample_date',
                'value' => $sample->sample_date,
                'disabled' => 1
            ])@enddatefield

            @textarea([
                'name' => 'remarks',
                'placeholder' => 'Enter the remarks',
                'value' => $sample->remarks,
                'disabled' => 1
            ])@endtextarea

            @select([
                'name' => 'status_id',
                'label' => 'STATUS',
                'elements' => $status_dd,
                'value' =>  $sample->status_id,
                'disabled' => 1
            ]) @endselect

    </div>
    @errors
    @enderrors
</div>

@endsection
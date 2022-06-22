@extends('layouts.app')
@section('dashboard')UPDATE SAMPLE @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{route('samples.update', ['sample'=>  $sample->id])}}">
            @method("PUT")
            @csrf
                <div class="row">
                    @text([
                        'name' => 'id',
                        'value' => $sample->id,
                        'disabled' => 1,
                    ])@endtext

                    @datefield([
                        'name' => 'sample_date',
                        'value' => $sample->sample_date,
                        'disabled' => $disabled
                    ])@enddatefield

                    @textarea([
                        'name' => 'remarks',
                        'placeholder' => 'Enter the remarks',
                        'value' => $sample->remarks,
                        'disabled' => $disabled
                    ])@endtextarea

                    @select([
                        'name' => 'status_id',
                        'label' => 'STATUS',
                        'elements' => $status_dd,
                        'value' =>  $sample->status_id
                    ]) @endselect
                </div>
                    
            <button type="submit" class="btn btn-secondary mt-4 form-btn">
                Submit
            </button>
        </form>
    </div>
    @errors
    @enderrors
</div>

@endsection
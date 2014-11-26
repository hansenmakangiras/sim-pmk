@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
{{-- Delete Form --}}
{{ Form::open(['id'=>'deleteForm', 'class'=>'form-horizontal']) }}
<input type="hidden" name="id" value="{{ $category->id }}" />
<!-- Form Actions -->
<div class="callout callout-danger">
    <h4>Are you sure you want to delete this category?</h4>
    <p>{{ $category->category}}</p>
</div>
<div class="form-actions">
    <button class="btn btn-warning close_popup">Cancel</button>
    <button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-trash-o"></i> Delete</button>
</div>
<!-- ./ form actions -->
{{ Form::close() }}
@stop
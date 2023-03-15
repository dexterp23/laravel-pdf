@extends('layouts.app')

@section('content')

<!-- Container -->
<div class="container">
    
    <div class="row">
        <div class="col-12 pt-2">
        	<a href="{{ route('pdf.add') }}" class="btn btn-primary">Potpisi PDF</a>
            <hr />
        </div>
        <div class="col-12">
        	<x-datatables />
        </div >
    </div>
    
</div>
<!-- /Container -->

@endsection

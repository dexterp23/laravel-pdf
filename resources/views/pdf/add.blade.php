@extends('layouts.app')

@section('content')
<!-- Container -->
<div class="container">

	<div class="row">
        <div class="col-12 mt-2">
        	<h1>Potpisi PDF</h1>
            <hr />
        </div>
        <div class="col-12">
        	<form action="{{ route('pdf.upload') }}" method="post" enctype="multipart/form-data" id="pdf_form">
                @csrf
                <input type="hidden" name="data_sign" id="data_sign" value="">
      
                <div class="mb-3">
					<label class="form-label" for="pdf_upload">upload PDF dokumenta</label>
					<input type="file" name="pdf" class="form-control" id="pdf_upload" />
				</div>
                
                <div class="card mb-3" style="width: 18rem;">
                	<canvas id="signature-pad" class="border"></canvas>
                    <div class="card-body">
                    	<h5 class="card-title">Vaš Potpis</h5>
                        <a href="javascript: void(0);" onclick="signaturePad.clear();" class="float-end">Obriši</a>
                    </div>
                </div>
                
                <div class="col-12">
                    <button class="btn btn-primary" type="button" onclick="SingSave();">Potpiši</button>
                    <a href="{{ route('pdf.list') }}" class="btn btn-light">Nazad</a>
                </div>

            </form>
        </div >
    </div>
                  
</div>
<!-- /Container -->

@endsection

@section('more_scripts')

    @include('pdf.add-js')

@endsection

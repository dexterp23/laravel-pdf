<script>

    const canvas = document.getElementById('signature-pad');
	const signaturePad = new SignaturePad(canvas);
	
	function SingSave () {
		
		var data = signaturePad.toDataURL('image/png');
		document.getElementById("data_sign").value = data;
		document.getElementById('pdf_form').submit();
			
	}

</script>

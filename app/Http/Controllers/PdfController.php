<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use setasign\Fpdi\Fpdi;

class PdfController extends Controller
{

	private $FileService;
	private $Fpdi;

    public function __construct( FileService $FileService, Fpdi $Fpdi ) 
	{
		$this->FileService = $FileService;
		$this->Fpdi = $Fpdi;
	}

    public function index()
    {

		return view('pdf.table');
		
    }
	
	public function add()
    {

		return view('pdf.add');
		
    }

    public function upload( Request $request ) 
	{
	
		$file = $request->file('pdf');
		
		
		if (isset ($file) && preg_match("/\bpdf\b|\bPDF\b/", $file->extension())) {
			
			$extension = $file->extension();
			$id_key = time().'-'.Str::random(10);
			
			//original
			$file_name = $file->getClientOriginalName();
			$file_name = preg_replace('/[^a-zA-Z0-9_ - .]/s',' ',$file_name);
			$file_name = trim(preg_replace('/\s+/', ' ', $file_name));
			$filePath = 'public/pdf/'.$id_key.'-'.$file_name;
			Storage::disk('local')->put($filePath, file_get_contents($file));
			$path_org = Storage::path($filePath);
			
			//image
			$data_uri = $request->data_sign;
			$encoded_image = explode(",", $data_uri)[1];
			$decoded_image = base64_decode($encoded_image);
			$filePath_image = 'public/pdf/signed/'.$id_key.'-signed-image.png';
			Storage::disk('local')->put($filePath_image, $decoded_image);
			$path_image = Storage::path($filePath_image);
			list($width_image, $height_image) = getimagesize($path_image);
			
			//signed
			$filePath_signed = 'public/pdf/signed/'.$id_key.'-signed.'.$extension;
			$pdf = $this->Fpdi;
			$pageCount = $pdf->setSourceFile($path_org);
			for ($p = 1; $p <= $pageCount; $p++) {
				$tppl = $pdf->importPage($p);
				$pdf->AddPage();
				$pdf->useTemplate($tppl, ['adjustPageSize' => true]);
				if ($pageCount == $p) {
					$width = $width_image*0.15;
					$height = $height_image*0.15;
					$x = $pdf->GetX();
					$y = $pdf->GetPageHeight() - ($pdf->GetY() + $height);
					$pdf->Image($path_image, $x, $y, $width, $height);
				}
			}
			Storage::disk('local')->put($filePath_signed, $pdf->Output("S"));
			
			return redirect()->route( 'pdf.list' )
			->with([
				'status'  => 'success',
				'message' => 'Dokument je uspešno potpisan.'
			]);
			
		} else {
			
			return redirect()->back()
			->with([
				'status'  => 'danger',
				'message' => 'Dokument mora da bude PDF!'
			])
			->withInput();
				
		}
	
	}
	
	public function view( string $file = '', string $type = 'original' ) 
	{
		
		$filePath_org = 'public/pdf/'.$file;
		
		if ($file && Storage::exists($filePath_org)) {
			
			$get_data = $this->FileService->GetData($filePath_org);
			
			switch ($type) {
				case 'original': 
					$name = $get_data['title_org'];
					return Storage::download($filePath_org, $name);
				break;
				case 'signed': 
					$filePath_sign = 'public/pdf/signed/'.$get_data['id_key'].'-signed.'.$get_data['extension'];
					if ($file && Storage::exists($filePath_sign)) {
						$name = $get_data['title'].'-signed.'.$get_data['extension'];
						return Storage::download($filePath_sign, $name);
					} else {
						return redirect()->route( 'pdf.list' )
						->with([
							'status'  => 'danger',
							'message' => 'Potpisani fajl ne postoji!'
						])
						->withInput();
					}
				break;
			}

		} else {
			return redirect()->route( 'pdf.list' )
			->with([
				'status'  => 'danger',
				'message' => 'Izaberite fajl!'
			])
			->withInput();
		}
		
	}
	
}
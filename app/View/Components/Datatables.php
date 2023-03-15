<?php

namespace App\View\Components;

use App\Services\FileService;
use Illuminate\View\Component;
use Storage;

class Datatables extends Component
{
	
	private $FileService;
	
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( FileService $FileService )
    {
        $this->FileService = $FileService;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
		
		$files = Storage::files('public/pdf/');
		$data = array ();
		
		foreach ($files as $file) {
			$get_data = $this->FileService->GetData($file);
			if (count($get_data) > 0) $data[] = $get_data;
		}
		$data = array_reverse($data);
		
        return view('components.datatables', compact('data'));
    }
}

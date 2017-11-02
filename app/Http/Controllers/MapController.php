<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MapController extends Controller {

	/**
     * Show the form to create a new record.
     *
     * @return Response
     */
	public function getIndex(){
		Log::info('Showing add client form for user.');
		return view('map');
	}


	public function getData(){
		//if tweet great than 1 hr	
		//else
		//if twee present in database
		//else find from gmap
		//end else
		//end else


		$data = [
		'status'   => 'Ok',
		'description'     => 'text',
		'lat'      => 'lat',
		'lng'      => 'lng',
		'errorMsg' => 'errorMessage'
		];

		echo json_encode($data);
	}
}
?>
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Kategori;

class ProdukController extends Controller
{
	public function __construct(){
		// $this->middleware('auth');
	}

	public function get(Request $request){
		$query = $request->query();

		if ($query) {

			if ($query['withDeleted'] == 'true') {
				# code...
				$produk = Produk::withTrashed()->get();
			} else {
				# code...
			}
			# code...
		} else {
			# code...
			// $produk = Produk::orderBy('created_at', 'desc')->take(10)->get();
			$produk = Produk::all();
		}
		
		return response()->json($produk);

	}

	public function getById($id) {

		$data = Produk::join('kategori','produk.id_kategori','=','kategori.id')
				->where('produk.id', $id)
				->select('produk.*',
						'kategori.kategori as Kategori'
						)
				->get();

			return response()->json($data);
	}

	public function create(Request $request){

		try {

	      	$produk = new Produk;
			$produk->judul = $request->input('judul');
			$produk->harga = $request->input('harga');
			$produk->gambar = $request->input('gambar');
			$produk->deskripsi = $request->input('deskripsi');
			$produk->id_kategori = $request->input('kategori');
			$produk->save();
			
			$response = [
				'status' => 'Success',
				'messages' => 'New Produk Created'
			];

			return response()->json($response, 200);
	    	
	   } catch (\Exception $e){
	      
	        $error_code = $e->errorInfo[1];
	      
	        if($error_code == 1062){

	        	$response = [
				'status' => 'Error',
				'messages' => 'You have a duplicate entry problem'
				];
	      
	            return response()->json($response, 400);
	        }
    	}
	}

	public function update(Request $request, $id) {
		$inputan = $request->all();
		
		try {

			$produk = Produk::find($id);

			if($produk) {

				Produk::where('id', $id);
				$produk->judul = $request->input('judul');
				$produk->harga = $request->input('harga');
				$produk->gambar = $request->input('gambar');
				$produk->deskripsi = $request->input('deskripsi');
				$produk->id_kategori = $request->input('kategori');
				$produk->save();
			
				$response['status'] = 'Success';
				$response['message'] = 'Produk with name '. $produk->judul .' updated';
			
				return response()->json($response);
			
			} else {
			
				$response['status'] = 'Error';
				$response['message'] = 'Produk with id ' . $id . ' Not Found';
			
				return response()->json($response, 404);
			}

		} catch (\Exception $e){
	    
	        $error_code = $e->errorInfo[1];
	    
	        if($error_code == 1062){

	        	$response = [
				'status' => 'Error',
				'messages' => 'You have a duplicate entry problem'
				];
	    
	            return response()->json($response, 400);
	        }
    	}
	}

	public function delete(Request $request, $id) {
		$response = [
			'status'=> null,
			'message'=> null
		];

		$inputan = $request->all();

		$produk = Produk::find($id);

		if ($produk) {

			Produk::where('id',$id)->delete();
			$response['status'] = 'Success';
			$response['message'] = 'Produk with name '.$produk->judul.' deleted';
			
			return response()->json($response);
		
		} else {
		
			$response['status'] = 'Error';
			$response['message'] = 'Produk with id ' . $id . ' Not Found';
			
			return response()->json($response, 404);
		}
	}
}


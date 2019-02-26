<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;

class KategoriController extends Controller
{
	public function __construct(){
		// $this->middleware('auth');
	}

	public function get(Request $request){
		$query = $request->query();
		if ($query) {
			if ($query['withDeleted'] == 'true') {
				$kategori = Kategori::withTrashed()->get();
			} 
		} else {
			$kategori = Kategori::all();
		}
		return response()->json($kategori);
	}

	public function getById($id){
		$kategori = Kategori::find($id);

		if($kategori){

			$response['result'] = $kategori;

			return response()->json($response, 200);
		}

		$response = ['status' => 'Error',
					'message' => 'Kategori with id ' . $id . ' Not Found'
					];
		
		return response()->json($response, 404);
	}

	public function getByProduk($id) {
		// $produk = Produk::orderBy('created_at', 'desc')->take(5)->get();

		$data = Kategori::join('produk','kategori.id','=','produk.id_kategori')
				->where('kategori.id', $id)
				->select('produk.*',
						'kategori.kategori as Kategori'
						)
				->orderBy('created_at', 'desc')->take(10)
				->get();

			return response()->json($data);
	}

	public function create(Request $request){
		try{
	        $kategori = new Kategori;
	        // $kategori->id_produk = $request->input('id_produk');
			$kategori->kategori = $request->input('kategori');
			$kategori->save();

			$response['status'] = 'Success';
			$response['message'] = 'New Kategori Submitted';
			
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
		try {

			$inputan = $request->all();

			$kategori = Kategori::find($id);

			if($kategori) {
				Kategori::where('id', $id);
				$kategori->kategori = $inputan['kategori'];
				$kategori->save();
			
				$response['status'] = 'Success';
				$response['message'] = 'Kategori with name '. $kategori->kategori .' updated';
			
				return response()->json($response);
			} else {
				$response['status'] = 'Error';
				$response['message'] = 'Kategori with id ' . $id . ' Not Found';
			
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

		$kategori = Kategori::find($id);

		if ($kategori) {
			Kategori::where('id',$id)->delete();
			$response['status'] = 'Success';
			$response['message'] = 'Kategori with name '.$kategori->name.' deleted';
			
			return response()->json($response);
		} else {
			$response['status'] = 'Error';
			$response['message'] = 'Kategori with id ' . $id . ' Not Found';
			
			return response()->json($response, 404);
		}
	}
}


<?php


namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductGallery;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->middleware('super_admin_check:store-update-destroy-destroyImage');
    }

    public function index(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
    }

    public function destroyImage($id)
    {
        
    }

    /**
     * filter and response
     *
     * @param $request
     * @param $query
     */
    private function filterAndResponse($request, $query)
    {
        
    }
}
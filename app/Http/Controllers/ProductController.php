<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\ProductDetails;
use App\Models\Bottle;

class ProductController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except('deleteSingleProduct');
    }

    /** list all products */
    public function listProduct(ProductDetails $model)
    {
        $products = $model->getAllProductWithBottles();
        return view('admin.product.index', compact('products'));
    }

    /** create product form */
    public function createProductForm()
    {
        // $bottle_list = $this->getBottleList();
        $bottle_list = [];
        return view('admin.product.create', compact('bottle_list'));
    }

    /** get bottle name image by id */
    public function bottleImageByID(Bottle $model)
    {
        $bottle_image = $model->bottleImageByID();
        return $bottle_image;
    }

    /** store product details */
    public function storeProduct(ProductDetails $model)
    {
        $data = request()->all();

        request()->validate([
            'asin'         => 'required|string|unique:product_details,asin',
            'status'       => 'required',
            'bottle_ids'   => 'required|array'
        ]);        

        try {
            if ($data['sortable_bottles'] && (count(explode(',', $data['sortable_bottles'])) == $data['bottle_ids'])) {
                $data['bottle_ids'] = json_encode($data['sortable_bottles']);
            } else {
                $data['bottle_ids'] = json_encode($data['bottle_ids']);
            }
            $model->create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return redirect('/admin/product')->with('flash_message', 'Product created successfully');
    }

    /** edit free bottle form */
    public function editProductForm(ProductDetails $model, $id)
    {
        $product = $model->findOrFail($id);
        // $bottle_list = $this->getBottleList();
        $bottle_list = [];
        return view('admin.product.edit', compact('product', 'bottle_list'));
    }

    /** update product */
    public function updateProduct(ProductDetails $model, $id)
    {
        $product = $model->findOrFail($id);
        $data = request()->all();

        request()->validate([
            'asin'         => 'required|string',
            'status'       => 'required',
            'bottle_ids'   => 'required|array'
        ]);

        try {
            $sortable_bottles = explode(',', $data['sortable_bottles']);

            if ($data['sortable_bottles'] && (count($sortable_bottles) == count($data['bottle_ids']))) {
                $data['bottle_ids'] = json_encode($sortable_bottles);
            } else $data['bottle_ids'] = json_encode($data['bottle_ids']);
            $product->update($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return redirect('/admin/product')->with('flash_message', 'Product updated');
    }

    /** delete product */
    public function deleteProduct(ProductDetails $model, $id)
    {
        $product = $model->findOrFail($id);
        $product->delete();
        return redirect('admin/product')->with('flash_message', 'ASIN deleted successfully');
    }

    private function getBottleList()
    {
        $model = new Bottle;
        $bottle_list = $model->getBottleList();
        // return $bottle_list->prepend('Please select bottles', '');
        return $bottle_list;
    }
}

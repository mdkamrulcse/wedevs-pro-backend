<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends ExtendController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
  public function index(Request $request){
      try{
          $query = Product::query();
          $query->orderBy('id', 'ASC');
          // Filter by keyword
          if ($request->has('keyword')) {
              $query->where('id', 'LIKE', "%{$request->get('keyword')}%");
              $query->orWhere('title', 'LIKE', "%{$request->get('keyword')}%");
          }
          // Retrieve execute
          $result = $query->paginate();
          // Return objects
          return ProductResource::collection($result);

      }catch (\Exception $ex){
          $this->sendError($ex->getMessage());
      }
  }

    /**
     * @param Request $request
     * @return ProductResource|\Illuminate\Http\JsonResponse
     */
  public function store(Request $request){
      try {
          $validator = Validator::make($request->all(),[
              'title' => 'required',
              'price' => 'required'
          ]);
          if ($validator->fails()) {
              return $this->sendValidationError($validator->errors());
          }
          $product = Product::create($request->all());
          return new ProductResource($product);
      }catch (\Exception $ex) {
          return $this->sendError($ex->getMessage());
      }
  }

    /**
     * @param Product $product
     * @return ProductResource|\Illuminate\Http\JsonResponse
     */
  public function show(Product $product){
      try {
          // Return object
          return new ProductResource($product);
      } catch (\Exception $ex) {
          return $this->sendError($ex->getMessage());
      }
  }

    /**
     * @param Request $request
     * @param Product $product
     * @return ProductResource|JsonResponse
     */
  public function update(Request $request, Product $product){
      try {
          $validator = Validator::make($request->all(),[
              'title' => 'required',
              'price' => 'required'
          ]);

          if ($validator->fails()) {
              return $this->sendValidationError($validator->errors());
          }

          $product->title = $request->title;
          $product->description = $request->description;
          $product->price = $request->price;
          $product->image = $request->image;
          $product->update();
          return new ProductResource($product);

      }catch (\Exception $ex) {
          return $this->sendError($ex->getMessage());
      }
  }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        try {
            // Execute delete
            $product->delete();

            // Return object
            return $this->sendResponse('Deleted Successfully.');

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function batchDelete(Request $request)
    {
        try {
            // Return empty request
            if (empty($request->ids)) {
                return $this->sendError("Invalid request parameters.");
            }

            $deletableIds = [];
            $explodeIds = explode(',', $request->ids);
            foreach ($explodeIds as $id) {
                $trimmedId = trim($id);
                if (is_numeric($trimmedId)) {
                    array_push($deletableIds, $trimmedId);
                }
            }

            // Return empty array
            if (empty($deletableIds)) {
                return $this->sendError("Invalid request parameters, 'array' not found.");
            }

            // Delete execute
            $countDeletedRows = Product::whereIn('id', $deletableIds)->delete();

            // Return response
            if ($countDeletedRows > 0) {
                return $this->sendResponse('Deleted Successfully.');
            } else {
                return $this->sendError('No item is deleted.');
            }

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

}

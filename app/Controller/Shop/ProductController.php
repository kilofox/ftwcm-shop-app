<?php

namespace App\Controller\Shop;

use Hyperf\Di\Annotation\Inject;
use Ftwcm\Shop\Product;

/**
 * 商品控制器。
 */
class ProductController extends \App\Controller\AbstractController
{
    /**
     * @Inject
     * @var Product
     */
    private $service;

    /**
     * 商品。
     */
    public function product()
    {
        $id = (int) $this->request->route('id', 0);
        $method = $this->request->getMethod();

        try {
            switch ($method) {
                case 'GET':
                default:
                    if ($id > 0) {
                        $data = $this->service->view($id);
                        $data->product_attributes = $this->service->getAttributes($id);
                        $data->product_options = $this->service->getProductOptions($id);
                    } else {
                        $sort = $this->request->input('sort', '');
                        $order = $this->request->input('order', '');
                        $page = (int) $this->request->route('page', 1);
                        $perPage = (int) $this->request->input('limit', 20);
                        $data = $this->service->list($sort, $order, $page, $perPage);
                        $items = [];

                        foreach ($data['items'] as $itemId) {
                            $items[] = $this->service->load($itemId);
                        }

                        $data['items'] = $items;
                    }
                    break;
                case 'POST':
                    $data = $this->service->create([
                        'name' => $this->request->post('name'),
                        'description' => $this->request->post('description'),
                        'tag' => $this->request->post('tag'),
                        'meta_title' => $this->request->post('meta_title'),
                        'meta_description' => $this->request->post('meta_description'),
                        'meta_keyword' => $this->request->post('meta_keyword'),
                        'model' => $this->request->post('model'),
                        'sku' => $this->request->post('sku'),
                        'upc' => $this->request->post('upc'),
                        'location' => $this->request->post('location'),
                        'price' => $this->request->post('price'),
                        'tax_class_id' => $this->request->post('tax_class_id'),
                        'quantity' => $this->request->post('quantity'),
                        'minimum' => $this->request->post('minimum'),
                        'subtract' => $this->request->post('subtract'),
                        'stock_status' => $this->request->post('stock_status'),
                        'shipping' => $this->request->post('shipping'),
                        'date_available' => $this->request->post('date_available'),
                        'length' => $this->request->post('length'),
                        'width' => $this->request->post('width'),
                        'height' => $this->request->post('height'),
                        'length_class' => $this->request->post('length_class'),
                        'weight' => $this->request->post('weight'),
                        'weight_class' => $this->request->post('weight_class'),
                        'status' => $this->request->post('status'),
                        'sort_order' => $this->request->post('sort_order'),
                        'image' => $this->request->post('image'),
                        'manufacturer_id' => $this->request->post('manufacturer_id'),
                        'category_ids' => $this->request->post('category_ids'),
                        'store_ids' => $this->request->post('store_ids'),
                        'product_attributes' => $this->request->post('product_attributes'),
                        'product_options' => $this->request->post('product_options'),
                    ]);
                    break;
                case 'PUT':
                    $data = $this->service->update($id, [
                        'name' => $this->request->post('name'),
                        'description' => $this->request->post('description'),
                        'tag' => $this->request->post('tag'),
                        'meta_title' => $this->request->post('meta_title'),
                        'meta_description' => $this->request->post('meta_description'),
                        'meta_keyword' => $this->request->post('meta_keyword'),
                        'model' => $this->request->post('model'),
                        'sku' => $this->request->post('sku'),
                        'upc' => $this->request->post('upc'),
                        'location' => $this->request->post('location'),
                        'price' => $this->request->post('price'),
                        'tax_class_id' => $this->request->post('tax_class_id'),
                        'quantity' => $this->request->post('quantity'),
                        'minimum' => $this->request->post('minimum'),
                        'subtract' => $this->request->post('subtract'),
                        'stock_status' => $this->request->post('stock_status'),
                        'shipping' => $this->request->post('shipping'),
                        'date_available' => $this->request->post('date_available'),
                        'length' => $this->request->post('length'),
                        'width' => $this->request->post('width'),
                        'height' => $this->request->post('height'),
                        'length_class' => $this->request->post('length_class'),
                        'weight' => $this->request->post('weight'),
                        'weight_class' => $this->request->post('weight_class'),
                        'status' => $this->request->post('status'),
                        'sort_order' => $this->request->post('sort_order'),
                        'image' => $this->request->post('image'),
                        'manufacturer_id' => $this->request->post('manufacturer_id'),
                        'category_ids' => $this->request->post('category_ids'),
                        'store_ids' => $this->request->post('store_ids'),
                        'product_attributes' => $this->request->post('product_attributes'),
                        'product_options' => $this->request->post('product_options'),
                    ]);
                    break;
                case 'DELETE':
                    $data = $this->service->delete($id);
                    break;
            }
        } catch (\Exception $e) {
            return $this->response->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'data' => null
            ]);
        }

        return $this->response->json([
                'code' => 200,
                'message' => 'Success',
                'data' => $data
        ]);
    }

}

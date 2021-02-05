<?php

namespace App\Controller\Shop;

use Hyperf\Di\Annotation\Inject;
use Ftwcm\Shop\Category;

/**
 * 分类控制器。
 */
class CategoryController extends \App\Controller\AbstractController
{
    /**
     * @Inject
     * @var Category
     */
    private $service;

    /**
     * 分类。
     */
    public function category()
    {
        $id = (int) $this->request->route('id', 0);
        $method = $this->request->getMethod();

        try {
            switch ($method) {
                case 'GET':
                default:
                    if ($id > 0) {
                        $data = $this->service->view($id);
                    } else {
                        $sort = $this->request->input('sort', '');
                        $order = $this->request->input('order', '');
                        $page = (int) $this->request->route('page', 1);
                        $perPage = (int) $this->request->input('limit', 20);
                        $data = $this->service->list($sort, $order, $page, $perPage);
                    }
                    break;
                case 'POST':
                    $data = $this->service->create([
                        'name' => $this->request->post('name'),
                        'parent_id' => $this->request->post('parent_id'),
                        'top' => $this->request->post('top'),
                        'column' => $this->request->post('column'),
                        'sort_order' => $this->request->post('sort_order'),
                        'status' => $this->request->post('status'),
                        'description' => $this->request->post('description'),
                        'meta_title' => $this->request->post('meta_title'),
                        'meta_description' => $this->request->post('meta_description'),
                        'meta_keyword' => $this->request->post('meta_keyword'),
                    ]);
                    break;
                case 'PUT':
                    $data = $this->service->update($id, [
                        'name' => $this->request->post('name'),
                        'parent_id' => $this->request->post('parent_id'),
                        'top' => $this->request->post('top'),
                        'column' => $this->request->post('column'),
                        'sort_order' => $this->request->post('sort_order'),
                        'status' => $this->request->post('status'),
                        'description' => $this->request->post('description'),
                        'meta_title' => $this->request->post('meta_title'),
                        'meta_description' => $this->request->post('meta_description'),
                        'meta_keyword' => $this->request->post('meta_keyword'),
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

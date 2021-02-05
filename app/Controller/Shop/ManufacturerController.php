<?php

namespace App\Controller\Shop;

use Hyperf\Di\Annotation\Inject;
use Ftwcm\Shop\Manufacturer;

/**
 * 制造商/品牌控制器。
 */
class ManufacturerController extends \App\Controller\AbstractController
{
    /**
     * @Inject
     * @var Manufacturer
     */
    private $service;

    /**
     * 制造商/品牌。
     */
    public function manufacturer()
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
                        'image' => $this->request->post('image'),
                        'sort_order' => $this->request->post('sort_order'),
                    ]);
                    break;
                case 'PUT':
                    $data = $this->service->update($id, [
                        'name' => $this->request->post('name'),
                        'image' => $this->request->post('image'),
                        'sort_order' => $this->request->post('sort_order'),
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

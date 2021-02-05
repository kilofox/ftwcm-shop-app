<?php

namespace App\Controller\Shop;

use Hyperf\Di\Annotation\Inject;
use Ftwcm\Shop\Option;
use Ftwcm\Shop\Product;

/**
 * 选项控制器。
 */
class OptionController extends \App\Controller\AbstractController
{
    /**
     * @Inject
     * @var Option
     */
    private $service;

    /**
     * 选项。
     */
    public function option()
    {
        $id = (int) $this->request->route('id', 0);
        $method = $this->request->getMethod();

        try {
            switch ($method) {
                case 'GET':
                default:
                    if ($id > 0) {
                        $data = $this->service->view($id);
                        $data->option_values = $this->service->getOptionValues($id);
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
                        'type' => $this->request->post('type'),
                        'sort_order' => $this->request->post('sort_order'),
                        'option_values' => $this->request->post('option_values'),
                    ]);
                    break;
                case 'PUT':
                    $data = $this->service->update($id, [
                        'name' => $this->request->post('name'),
                        'type' => $this->request->post('type'),
                        'sort_order' => $this->request->post('sort_order'),
                        'option_values' => $this->request->post('option_values'),
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

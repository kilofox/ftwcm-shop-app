<?php

namespace App\Controller\Shop;

use Hyperf\Di\Annotation\Inject;
use Ftwcm\Shop\Attribute;
use Ftwcm\Shop\AttributeGroup;

/**
 * 属性控制器。
 */
class AttributeController extends \App\Controller\AbstractController
{
    /**
     * @Inject
     * @var Attribute
     */
    private $service;

    /**
     * @Inject
     * @var AttributeGroup
     */
    private $groupService;

    /**
     * 属性。
     */
    public function attribute()
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
                        'group_id' => $this->request->post('group_id'),
                        'sort_order' => $this->request->post('sort_order', 0),
                    ]);
                    break;
                case 'PUT':
                    $data = $this->service->update($id, [
                        'name' => $this->request->post('name'),
                        'group_id' => $this->request->post('group_id'),
                        'sort_order' => $this->request->post('sort_order', 0),
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

    /**
     * 属性分组。
     */
    public function attributeGroup()
    {
        $id = (int) $this->request->route('id', 0);
        $method = $this->request->getMethod();

        try {
            switch ($method) {
                case 'GET':
                default:
                    if ($id > 0) {
                        $data = $this->groupService->view($id);
                    } else {
                        $sort = $this->request->input('sort', '');
                        $order = $this->request->input('order', '');
                        $page = (int) $this->request->route('page', 1);
                        $perPage = (int) $this->request->input('limit', 20);
                        $data = $this->service->list($sort, $order, $page, $perPage);
                        $items = [];

                        foreach ($data['items'] as $itemId) {
                            $item = $this->groupService->load($itemId);
                            if (!$item) {
                                continue;
                            }
                            $items[] = $item;
                        }

                        $data['items'] = $items;
                    }
                    break;
                case 'POST':
                    $data = $this->groupService->create([
                        'name' => $this->request->post('name'),
                        'sort_order' => $this->request->post('sort_order', 0),
                    ]);
                    break;
                case 'PUT':
                    $data = $this->groupService->update($id, [
                        'name' => $this->request->post('name'),
                        'sort_order' => $this->request->post('sort_order'),
                    ]);
                    break;
                case 'DELETE':
                    $data = $this->groupService->delete($id);
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

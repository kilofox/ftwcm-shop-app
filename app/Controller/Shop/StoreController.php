<?php

namespace App\Controller\Shop;

use Hyperf\Di\Annotation\Inject;
use Ftwcm\Shop\Store;

/**
 * 商店控制器。
 */
class StoreController extends \App\Controller\AbstractController
{
    /**
     * @Inject
     * @var Store
     */
    private $service;

    /**
     * 商店。
     */
    public function store()
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
                        $data = $this->service->fetch();
                    }
                    break;
                case 'POST':
                    $data = $this->service->create([
                        'name' => $this->request->post('name'),
                    ]);
                    break;
                case 'PUT':
                    $data = $this->service->update($id, [
                        'name' => $this->request->post('name'),
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

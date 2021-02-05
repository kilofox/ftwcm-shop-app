<?php

namespace App\Controller\Shop;

use Hyperf\Di\Annotation\Inject;
use Ftwcm\Shop\Cart;

/**
 * 购物车控制器。
 */
class CartController extends \App\Controller\AbstractController
{
    /**
     * @Inject
     * @var Cart
     */
    private $service;

    /**
     * @Inject
     * @var \Hyperf\Rpc\Context
     */
    protected $context;

    /**
     * 购物车。
     */
    public function cart()
    {
        $method = $this->request->getMethod();

        try {
            /** @var array $user 当前登录用户 */
            $user = $this->context->get('user');
            $user['id'] = 1;
            if (empty($user['id'])) {
                throw \Exception('未登录', 401);
            }

            switch ($method) {
                case 'GET':
                default:
                    $products = $this->service->getProducts($user['id']);

                    foreach ($products as $product) {
                        $productTotal = 0;

                        foreach ($products as $p2) {
                            if ($p2->product_id === $product->product_id) {
                                $productTotal += $p2->quantity;
                            }
                        }

                        if ($product->minimum > $productTotal) {
                            $data['warning'] = $product->name . ' 的最小订单数量为 ' . $product->minimum;
                        }
                    }

                    $data['products'] = $products;
                    break;
                case 'POST':
                    $productId = (int) $this->request->post('productId');
                    $quantity = (int) $this->request->post('quantity', 1);
                    $option = array_filter((array) $this->request->post('option', []));
                    $data = $this->service->addToCart($user['id'], $productId, $quantity, $option);
                    break;
                case 'PUT':
                    $quantity = $this->request->post('quantity');

                    foreach ($quantity as $item) {
                        $cart = $this->service->load($item['key']);

                        if (!$cart || $cart->user_id <> $user['id']) {
                            throw new \Exception('购物车 [' . $item['key'] . '] 不存在', 400);
                        }

                        // 修改数量
                        $cart->quantity = $item['quantity'];
                        $this->service->updateCart($cart);
                    }
                    $data = true;
                    break;
                case 'DELETE':
                    $data = $this->service->removeFromCart($user['id'], $this->request->post('keys'));
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

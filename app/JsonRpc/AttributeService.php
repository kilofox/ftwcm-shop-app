<?php

namespace App\JsonRpc;

use Hyperf\Di\Annotation\Inject;
use Hyperf\RpcServer\Annotation\RpcService;
use App\Helpers\Helper;
use Ftwcm\Shop\AttributeGroup;
use App\Exception\AppBadRequestException;
use App\Exception\AppUnauthorizedException;
use App\Exception\AppNotFoundException;

/**
 * 商品属性API。
 *
 * @RpcService(name="shop.attribute", protocol="jsonrpc", server="jsonrpc", publishTo="consul")
 */
class AttributeService
{
    /**
     * @Inject
     * @var AttributeGroup
     */
    private $service;
    /**
     * @Inject
     * @var Helper
     */
    protected $helper;

    /**
     * @Inject
     * @var \Hyperf\Rpc\Context
     */
    protected $context;

    /**
     * 商品属性详细。
     *
     * @param int $id 商品属性ID
     * @return array
     */
    public function attribute(int $id): array
    {
        try {
            $attribute = $this->service->getAttribute($id);

            if (!$attribute) {
                throw new AppNotFoundException('商品属性不存在');
            }

            return $this->helper->success($attribute);
        } catch (\Throwable $e) {
            return $this->helper->error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 添加新商品属性。
     *
     * @param array $data 商品属性
     * @return array
     */
    public function attributeAddition(array $data): array
    {
        $attributes = $this->service->getAttributes();
        if (count($attributes) > 9) {
            return $this->helper->error(400, '最多可创建10个商品属性');
        }

        try {
            $result = $this->service->addAttribute($user['id'], $data);

            return $this->helper->success($result);
        } catch (\Throwable $e) {
            return $this->helper->error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 商品属性列表。
     *
     * @return array
     */
    public function attributees(): array
    {
        try {
            $attributes = $this->service->getAttributes();

            return $this->helper->success($attributes);
        } catch (\Throwable $e) {
            return $this->helper->error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 商品属性删除。
     *
     * @param int $id 商品属性ID
     * @return array
     */
    public function attributeDeletion(int $id): array
    {
        try {
            $result = $this->service->deleteAttribute($user['id'], $id);

            return $this->helper->success($result);
        } catch (\Throwable $e) {
            return $this->helper->error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 商品属性更新。
     *
     * @param int $id 商品属性ID
     * @param array $data 商品属性数据
     * @return array
     */
    public function attributeUpdate(int $id, array $data): array
    {
        $attribute = $this->service->getAttribute($id);
        if (!$attribute) {
            return $this->helper->error(404, '商品属性不存在');
        }

        $attributes = $attribute->getAttributes();

        foreach ($data as $attr => $value) {
            if (array_key_exists($attr, $attributes)) {
                $attribute->$attr = $value;
            }
        }

        try {
            $result = $this->service->updateAttribute($attribute);

            return $this->helper->success($result);
        } catch (\Throwable $e) {
            return $this->helper->error($e->getCode(), $e->getMessage());
        }
    }

}

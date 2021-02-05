<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;
use App\Controller\Shop\CategoryController;
use App\Controller\Shop\AttributeController;
use App\Controller\Shop\OptionController;
use App\Controller\Shop\ManufacturerController;
use App\Controller\Shop\StoreController;
use App\Controller\Shop\ProductController;
use App\Controller\Shop\CartController;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});

Router::addGroup('/ftwcm/shop/', function () {
    Router::get('categories[/{id:\d+}]', [CategoryController::class, 'category']);
    Router::post('categories', [CategoryController::class, 'category']);
    Router::put('categories/{id:\d+}', [CategoryController::class, 'category']);
    Router::delete('categories/{id:\d+}', [CategoryController::class, 'category']);

    Router::get('attributes[/{id:\d+}]', [AttributeController::class, 'attribute']);
    Router::post('attributes', [AttributeController::class, 'attribute']);
    Router::put('attributes/{id:\d+}', [AttributeController::class, 'attribute']);
    Router::delete('attributes/{id:\d+}', [AttributeController::class, 'attribute']);

    Router::get('attributes/groups[/{id:\d+}]', [AttributeController::class, 'attributeGroup']);
    Router::post('attributes/groups', [AttributeController::class, 'attributeGroup']);
    Router::put('attributes/groups/{id:\d+}', [AttributeController::class, 'attributeGroup']);
    Router::delete('attributes/groups/{id:\d+}', [AttributeController::class, 'attributeGroup']);

    Router::get('options[/{id:\d+}]', [OptionController::class, 'option']);
    Router::post('options', [OptionController::class, 'option']);
    Router::put('options/{id:\d+}', [OptionController::class, 'option']);
    Router::delete('options/{id:\d+}', [OptionController::class, 'option']);

    Router::get('manufacturers[/{id:\d+}]', [ManufacturerController::class, 'manufacturer']);
    Router::post('manufacturers', [ManufacturerController::class, 'manufacturer']);
    Router::put('manufacturers/{id:\d+}', [ManufacturerController::class, 'manufacturer']);
    Router::delete('manufacturers/{id:\d+}', [ManufacturerController::class, 'manufacturer']);

    Router::get('stores[/{id:\d+}]', [StoreController::class, 'store']);
    Router::post('stores', [StoreController::class, 'store']);
    Router::put('stores/{id:\d+}', [StoreController::class, 'store']);
    Router::delete('stores/{id:\d+}', [StoreController::class, 'store']);

    Router::get('products[/{id:\d+}]', [ProductController::class, 'product']);
    Router::post('products', [ProductController::class, 'product']);
    Router::put('products/{id:\d+}', [ProductController::class, 'product']);
    Router::delete('products/{id:\d+}', [ProductController::class, 'product']);

    Router::get('cart', [CartController::class, 'cart']);
    Router::post('cart', [CartController::class, 'cart']);
    Router::put('cart', [CartController::class, 'cart']);
    Router::delete('cart', [CartController::class, 'cart']);
});

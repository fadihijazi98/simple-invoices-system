<?php

namespace Tests;

use App\Facades\AppHelper;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    protected function newStore(array $data)
    {
        $response = $this->post('/api/store', $data);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('store.id');
        });

        return [AppHelper::getResponseData($response, 'store'), $response];
    }

    protected function newItem($data)
    {
        $response = $this->post("/api/item", $data);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('item.id');
        });

        return [AppHelper::getResponseData($response, 'item'), $response];
    }

    protected function newInvoice($storeID, $data)
    {
        $response = $this->post("/api/store/$storeID/invoice", $data);

        /*$response->assertJson(function (AssertableJson $json) {
            $json->has('invoice.id');
        });*/

        return [AppHelper::getResponseData($response, 'invoice'), $response];
    }
}

<?php

namespace Tests\Feature;

use App\Constants\Status;
use App\Facades\AppHelper;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreInvoicesTest extends TestCase
{
    /** @test */
    public function userCanCreateStore()
    {
        list($store, $response) =
            $this->newStore([
                'name' => 'Store A'
            ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                'store.id',
                'store.name',
                'store.created_at',
                'store.updated_at',
            ]);
        });

        $this->assertEquals('Store A', $store->name);

        $response->assertStatus(200);
    }

    /** @test */
    public function userCanCreateInvoiceBelongsToStore()
    {
        list($store) = $this->newStore([
            'name' => 'Store A'
        ]);

        /** @var Invoice $invoice */
        list($invoice) = $this->newInvoice($store->id, [
            'customer_name' => 'Customer A',
            'status' => Status::UN_PAID,
        ]);

        $this->assertEquals($store->id, $invoice->store_id);
        $this->assertEquals('Customer A', $invoice->customer_name);
        $this->assertEquals(Status::UN_PAID, $invoice->status);

        $this->assertEquals($invoice->store, $store);
    }

    private function newStore(array $data)
    {
        $response = $this->post('/api/store', $data);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('store.id');
        });

        return [AppHelper::getResponseData($response, 'store'), $response];
    }

    private function newInvoice($storeID, $data)
    {
        $response = $this->post("/api/store/$storeID/invoice", $data);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('invoice.id');
        });

        return [AppHelper::getResponseData($response, 'invoice'), $response];
    }
}

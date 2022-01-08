<?php

namespace Tests\Feature;

use App\Constants\Status;
use App\Models\Invoice;
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

        list($invoice) = $this->newInvoice($store->id, [
            'customer_name' => 'Customer A',
            'status' => Status::UN_PAID,
        ]);

        $this->assertEquals($store->id, $invoice->store_id);
        $this->assertEquals('Customer A', $invoice->customer_name);
        $this->assertEquals(Status::UN_PAID, $invoice->status);
    }
}

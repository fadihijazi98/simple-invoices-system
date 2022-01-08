<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\Invoice;
use App\Models\Store;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function store(Store $store, Request $request)
    {
        $statuses = Status::PAID . ',' . Status::UN_PAID;

        $validated =
            $request->validate([
                'customer_name' => 'required',
                'status' => 'required|in:' . $statuses,
            ]);

        $invoice =
            $store
                ->invoices()
                ->create($validated);

        return
            response()
                ->json([
                    'store' => $invoice->store,
                    'invoice' => $invoice,
                ]);
    }
}

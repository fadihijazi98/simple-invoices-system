<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $store = Store::create($validated);

        return
            response()
                ->json([
                    'store' => $store
                ]);
    }
}

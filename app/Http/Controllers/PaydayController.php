<?php

namespace App\Http\Controllers;

use App\Actions\PaydayAction;
use Illuminate\Http\Request;

class PaydayController extends Controller
{
    public function __construct(private readonly PaydayAction $paydayAction)
    {
    }

    public function store(Request $request)
    {
        $this->paydayAction->execute();

        return response()->noContent();
    }
}

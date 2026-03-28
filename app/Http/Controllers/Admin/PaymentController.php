<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function stripeWebhook(Request $request)
    {
        // À configurer avec STRIPE_WEBHOOK_SECRET
        // Vérifier signature et mettre à jour payment_status
        return response()->json(['received' => true]);
    }
}

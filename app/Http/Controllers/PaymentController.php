<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\Payment;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function pagar(Post $post)
    {

        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
        $client = new PreferenceClient();

        $plan = $post->plan;

        $preference = $client->create([
            "items" => [
                [
                    "title" => $post->title,
                    "quantity" => 1,
                    "unit_price" => (float) $post->plan->price
                ]
            ]
        ]);

        return Inertia::render('Payments/Checkout', [
            'post' => $post,
            'plan' => $plan,
            'preferenceId' => $preference->id,
            'mpKey' => config('services.mercadopago.public_key'),
            'csrf_token' => csrf_token(),

        ]);
    }

    public function processPayment(Request $request)
    {

        Log::info("📥 BRICK DATA:", $request->all());

        try {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
            $client = new PaymentClient();

            $payment = $client->create([
                "transaction_amount" => (float) $request->formData['transaction_amount'],
                "token" => $request->formData['token'],
                "description" => "Pago de anuncio ID {$request->post_id}",
                "installments" => $request->formData['installments'],
                "payment_method_id" => $request->formData['payment_method_id'],
                "issuer_id" => $request->formData['issuer_id'],
                "payer" => [
                    "email" => $request->formData['payer']['email'] ?? null,
                ]
            ]);

            $pay = Payment::create([
                'user_id' =>  Auth::id(),
                'post_id' => $request->post_id,
                'plan_id' => $request->plan_id,
                'payment_id' => $payment->id,
                'status' => $payment->status,
                'amount' => $request->transaction_amount,
                'payload' => json_encode($payment),
            ]);

            if ($payment->status === 'approved') {
                $post = Post::findOrFail($request->post_id);
                $plan = Plan::findOrFail($request->plan_id);

                $post->start = now();
                $post->end = now()->addDays($plan->duration);
                $post->is_premium = true;
                $post->status = 'active';
                $post->plan_id = $plan->id;
                $post->save();

                return response()->json([
                    'status' => 'success',
                    'redirect' => route('thanks'),
                ]);
            }
            Log::info('✅ Resultado del pago', json_decode(json_encode($pay), true));

            return response()->json(['status' => 'error', 'message' => 'Pago no aprobado']);
        } catch (MPApiException $e) {
            Log::error('❌ MP API ERROR:', [
                'message' => $e->getMessage(),
                'status_code' => $e->getApiResponse()->getStatusCode() ?? null,
                'body' => $e->getApiResponse()->getContent() ?? null,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error en Mercado Pago',
                'details' => $e->getMessage(),
                'mp_response' => $e->getApiResponse()->getContent() ?? null
            ]);
        } catch (\Exception $e) {
            Log::error('❌ ERROR GENERAL: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error general']);
        }
    }

    public function thanks(){
        return Inertia::render('Payments/Thanks');
    }


    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

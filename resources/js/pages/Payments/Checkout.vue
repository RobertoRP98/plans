<script setup>
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { toast } from 'vue-sonner';

const { props } = usePage();
const plan = props.plan;
const post = props.post;
const publicKey = props.mpKey;
const preferenceId = props.preferenceId;
const csrf_token = props.csrf_token;

console.log('PUBLIC KEY:', publicKey, typeof publicKey);
console.log(props);
console.log('CSRF:', props.csrf_token);

function initBrick() {
    const mp = new MercadoPago(publicKey, { locale: 'es-MX' });
    const bricksBuilder = mp.bricks();

    bricksBuilder.create('payment', 'paymentBrick_container', {
        initialization: {
            amount: plan.price,
            preferenceId: props.preferenceId,
            payer: {
                email: props.auth?.user?.email ?? '',
                firstName: props.auth?.user?.name ?? '',
                entityType: 'individual',
            },
        },

        mercadoPago: {
            preferenceId: preferenceId,
        },

        customization: {
            visual: {
                style: {
                    theme: 'default',
                },
            },
            paymentMethods: {
                creditCard: 'all',
                debitCard: 'all',
                onboarding_credits: 'all',
                wallet_purchase: 'all',
                maxInstallments: 3,
            },
        },

        callbacks: {
            onReady: () => {
                console.log('Payment Brick listo');
            },

            onSubmit: (formData) => {
                return new Promise((resolve, reject) => {
                    fetch('/process-payment', {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': props.csrf_token,
                        },
                        body: JSON.stringify({
                            ...formData,
                            post_id: post.id,
                            plan_id: plan.id,
                            transaction_amount: Number(plan.price),
                        }),
                    })
                        .then((res) => res.json())
                        .then((res) => {
                            if (res.status === 'success') {
                                // 1. Muestra el toast usando el mensaje que vino en el JSON
                                if (res.toast_message) {
                                    // Usas la función 'toast' que importaste en este componente
                                    toast.success(res.toast_message);

                                    router.visit(res.redirect, {
                                        // La visita de Inertia se hace, pero el toast ya se disparó.
                                        preserveScroll: true,
                                        onSuccess: () => {
                                            resolve(); // Resuelve la promesa de MP
                                        },
                                    });
                                }
                            } else {
                                if (res.message) {
                                    toast.error(res.message);
                                }
                                reject();
                            }
                        })
                        .catch(reject);
                });
            },

            onError: (error) => {
                console.error('Error en MEPA Brick:', error);
            },
        },
    });
}

onMounted(() => {
    const script = document.createElement('script');
    script.src = 'https://sdk.mercadopago.com/js/v2';
    script.onload = () => initBrick();
    document.body.appendChild(script);
});
</script>

<template>
    <Head title="Pagar Anuncio" />

    <AppLayout>
        <div class="mx-auto max-w-3xl py-10">
            <h1 class="text-2xl font-bold">Pago del anuncio</h1>

            <p class="mt-2">
                Plan seleccionado: <strong>{{ plan.name }}</strong>
            </p>
            <p>Precio: ${{ plan.price }}</p>

            <div id="paymentBrick_container" class="mt-6"></div>
        </div>
    </AppLayout>
</template>

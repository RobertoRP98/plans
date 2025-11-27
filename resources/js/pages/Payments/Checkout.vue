<script setup>
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
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
                // onboarding_credits: 'all',
                // wallet_purchase: 'all',
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
                                window.location.href = res.redirect;
                                return;
                            } else {
                                toast.error(res.message || 'Error en el pago');
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

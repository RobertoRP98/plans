import {router} from '@inertiajs/vue3';
import {toast} from 'vue-sonner'

export function deleteState(id) {
    if (confirm('¿Estas seguro?')) {
        router.delete(`/estados/${id}`, {
            preserveScroll: true,
            onSuccess: () => toast.success('Estado eliminado correctamente'),
            onError: () => toast.error('Error al eliminar estado'),
        });
    }
};
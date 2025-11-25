<script setup lang="ts">
</script>

<template>
<footer class="w-full bg-[#fca5a5] text-[#4a1f1f] py-10 mt-10">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">

        <!-- Columna 1 -->
        <div>
            <h2 class="text-2xl font-bold text-[#7f1d1d] mb-3">MiSitio</h2>
            <p class="text-[#4a1f1f] leading-relaxed">
                Tu plataforma confiable para compras seguras y rápidas.  
                ¡Gracias por visitarnos!
            </p>
        </div>

        <!-- Columna 2 -->
        <div>
            <h3 class="text-xl font-semibold text-[#7f1d1d] mb-4">Navegación</h3>
            <ul class="space-y-2">
                <li><a href="/" class="hover:text-[#7f1d1d] transition">Inicio</a></li>
                <li><a href="/productos" class="hover:text-[#7f1d1d] transition">Productos</a></li>
                <li><a href="/contacto" class="hover:text-[#7f1d1d] transition">Contacto</a></li>
                <li><a href="/acerca" class="hover:text-[#7f1d1d] transition">Acerca de</a></li>
            </ul>
        </div>

        <!-- Columna 3 -->
        <div>
            <h3 class="text-xl font-semibold text-[#7f1d1d] mb-4">Síguenos</h3>

            <div class="flex gap-4">
                <a href="#" class="bg-[#fecaca] p-3 rounded-full hover:bg-[#f87171] transition">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#" class="bg-[#fecaca] p-3 rounded-full hover:bg-[#f87171] transition">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" class="bg-[#fecaca] p-3 rounded-full hover:bg-[#f87171] transition">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="#" class="bg-[#fecaca] p-3 rounded-full hover:bg-[#f87171] transition">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>

    </div>

    <div class="border-t border-[#7f1d1d] mt-10 pt-5 text-center text-[#4a1f1f] text-sm">
        © {{ new Date().getFullYear() }} MiSitio — Todos los derechos reservados.
    </div>
</footer>

</template>

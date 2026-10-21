<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section class="py-14 bg-areia">
    <div class="max-w-[1200px] mx-auto px-6">
        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-azul-principal mb-3.5">Comunidades parceiras</p>
        <h3 class="font-display text-lg font-semibold text-preto mb-6.5">
            Fazemos parte de uma rede de comunidades PHP do <span class="text-azul-principal">Nordeste.</span>
        </h3>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
            <div class="text-center">
                <div class="grid place-items-center w-16 h-16 mx-auto mb-3 p-3 rounded-full bg-white shadow-[0_4px_14px_rgba(8,45,82,.08)]">
                    <img src="{{ asset('images/communities/php-pi.png') }}" alt="PHP-PI" class="w-full h-full object-contain">
                </div>
                <h4 class="text-[13px] font-semibold text-preto">PHP-PI</h4>
                <p class="text-[11.5px] text-cinza">Piauí</p>
            </div>
            <div class="text-center">
                <div class="grid place-items-center w-16 h-16 mx-auto mb-3 p-3 rounded-full bg-white shadow-[0_4px_14px_rgba(8,45,82,.08)]">
                    <img src="{{ asset('images/communities/php-ma.png') }}" alt="PHP Maranhão" class="w-full h-full object-contain">
                </div>
                <h4 class="text-[13px] font-semibold text-preto">PHP-MA</h4>
                <p class="text-[11.5px] text-cinza">Maranhão</p>
            </div>
            <div class="text-center">
                <div class="grid place-items-center w-16 h-16 mx-auto mb-3 p-3 rounded-full bg-white shadow-[0_4px_14px_rgba(8,45,82,.08)]">
                    <img src="{{ asset('images/communities/php-com-rapadura.png') }}" alt="PHP com Rapadura" class="w-full h-full object-contain">
                </div>
                <h4 class="text-[13px] font-semibold text-preto">PHP com Rapadura</h4>
                <p class="text-[11.5px] text-cinza">Ceará</p>
            </div>
            <div class="text-center">
                <div class="grid place-items-center w-16 h-16 mx-auto mb-3 rounded-full bg-white text-azul-principal font-display font-bold text-lg shadow-[0_4px_14px_rgba(8,45,82,.08)]">JS</div>
                <h4 class="text-[13px] font-semibold text-preto">ParaíbaJS</h4>
                <p class="text-[11.5px] text-cinza">Paraíba</p>
            </div>
            <div class="text-center">
                <div class="grid place-items-center w-16 h-16 mx-auto mb-3 p-3 rounded-full bg-white shadow-[0_4px_14px_rgba(8,45,82,.08)]">
                    <img src="{{ asset('images/communities/php-pe.png') }}" alt="PHP-PE" class="w-full h-full object-contain">
                </div>
                <h4 class="text-[13px] font-semibold text-preto">PHP-PE</h4>
                <p class="text-[11.5px] text-cinza">Pernambuco</p>
            </div>
            <div class="text-center">
                <div class="grid place-items-center w-16 h-16 mx-auto mb-3 p-3 rounded-full bg-white shadow-[0_4px_14px_rgba(8,45,82,.08)]">
                    <img src="{{ asset('images/communities/php-rn.png') }}" alt="PHP-RN" class="w-full h-full object-contain">
                </div>
                <h4 class="text-[13px] font-semibold text-preto">PHP-RN</h4>
                <p class="text-[11.5px] text-cinza">Rio Grande do Norte</p>
            </div>
        </div>
    </div>
</section>

<div>
    @if ($abierto && $mesaSeleccionada)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            wire:click.self="cerrar"
        >
            <div class="w-full max-w-sm rounded-xl bg-white p-6 shadow-xl">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-au-brown-darkest">
                            {{ $mesaSeleccionada->nombre }}
                        </h2>

                        <p class="text-sm text-au-text-muted">
                            Capacidad: {{ $mesaSeleccionada->capacidad }} personas
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="cerrar"
                        class="text-2xl text-au-text-muted hover:text-au-coral"
                    >
                        &times;
                    </button>
                </div>

                <div class="flex justify-center rounded-lg bg-white p-3">
                    {!! $qrSvg !!}
                </div>

                <p class="mt-4 text-center text-sm text-au-text-muted">
                    ¿En qué formato deseas descargar el QR?
                </p>

                <div class="mt-4 flex justify-center gap-3">
                    <a
                        href="{{ route('mesa.descargarQrImagen', $mesaSeleccionada->id) }}"
                        class="rounded-lg bg-au-coral px-4 py-2 text-sm font-medium text-white"
                    >
                        Imagen PNG
                    </a>

                    <a
                        href="{{ route('mesa.descargarQrPdf', $mesaSeleccionada->id) }}"
                        class="rounded-lg bg-au-brown-dark px-4 py-2 text-sm font-medium text-white"
                    >
                        PDF
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

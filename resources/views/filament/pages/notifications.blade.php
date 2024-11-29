<x-filament::page>
    <div class="space-y-6">
        @forelse ($this->notifications as $notification)
            <div class="bg-white overflow-hidden shadow-sm rounded-lg transition duration-300 ease-in-out hover:shadow-md">
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            @if ($notification->read_at)
                                <x-heroicon-o-check-circle class="h-8 w-8 text-primary-500" />
                            @else
                                <x-heroicon-o-bell class="h-8 w-8 text-blue-500 animate-bounce" />
                            @endif
                        </div>
                        <div class="flex-grow min-w-0">
                            <p class="text-m font-medium text-gray-900 mb-1">
                                {{ $notification->data['message'] ?? 'Notificación' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex-shrink-0 flex space-x-4"> <!-- Ajusta space-x-4 o cualquier valor deseado -->
                            @unless ($notification->read_at)
                                <x-filament::button
                                    wire:click="markAsRead('{{ $notification->id }}')"
                                    color="primary"
                                    size="sm"
                                    icon="heroicon-s-eye"
                                >
                                    Leer
                                </x-filament::button>
                            @endunless
                            <x-filament::button
                                wire:click="delete('{{ $notification->id }}')"
                                color="danger"
                                size="sm"
                                icon="heroicon-s-trash"
                            >
                                Eliminar
                            </x-filament::button>
                        </div>                        
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <x-heroicon-o-bell-slash class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-m font-medium text-gray-900">No hay notificaciones</h3>
                <p class="mt-1 text-sm text-gray-500">Cuando recibas notificaciones, aparecerán aquí.</p>
            </div>
        @endforelse
    </div>
</x-filament::page>
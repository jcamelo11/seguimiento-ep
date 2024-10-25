<x-filament::page>
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
        

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-emerald-100 dark:bg-emerald-800 text-emerald-700 dark:text-emerald-200">
                        <th class="px-6 py-4 font-semibold text-left">Instructor</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Asignados</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Activos</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Por Certificar</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Certificados</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Retirados/Cancelados</th>
                        <th class="px-6 py-4 font-semibold text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->getInstructoresData() as $instructor)
                        <tr>
                            <td class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-200">{{ $instructor->nombres }} {{ $instructor->apellidos }}</td>
                            <td class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-center text-gray-900 dark:text-gray-200">{{ $instructor->total_asignados }}</td>
                            <td class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-center text-gray-900 dark:text-gray-200">{{ $instructor->total_activos }}</td>
                            <td class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-center text-gray-900 dark:text-gray-200">{{ $instructor->total_por_certificar }}</td>
                            <td class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-center text-gray-900 dark:text-gray-200">{{ $instructor->total_certificados }}</td>
                            <td class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-center text-gray-900 dark:text-gray-200">{{ $instructor->total_retirados_cancelados }}</td>
                            <td class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-center font-semibold text-gray-900 dark:text-gray-200">{{ $instructor->total_asignados }}</td>
                        </tr>
                    @endforeach

                    <!-- Sumas totales -->
                    <tr class="bg-emerald-50 dark:bg-emerald-900 font-bold text-emerald-800 dark:text-emerald-200">
                        <td class="px-6 py-4 border-t-2 border-emerald-600 dark:border-emerald-500">Total</td>
                        <td class="px-6 py-4 border-t-2 border-emerald-600 dark:border-emerald-500 text-center">{{ $this->getInstructoresData()->sum('total_asignados') }}</td>
                        <td class="px-6 py-4 border-t-2 border-emerald-600 dark:border-emerald-500 text-center">{{ $this->getInstructoresData()->sum('total_activos') }}</td>
                        <td class="px-6 py-4 border-t-2 border-emerald-600 dark:border-emerald-500 text-center">{{ $this->getInstructoresData()->sum('total_por_certificar') }}</td>
                        <td class="px-6 py-4 border-t-2 border-emerald-600 dark:border-emerald-500 text-center">{{ $this->getInstructoresData()->sum('total_certificados') }}</td>
                        <td class="px-6 py-4 border-t-2 border-emerald-600 dark:border-emerald-500 text-center">{{ $this->getInstructoresData()->sum('total_retirados_cancelados') }}</td>
                        <td class="px-6 py-4 border-t-2 border-emerald-600 dark:border-emerald-500 text-center font-semibold">{{ $this->getInstructoresData()->sum('total_asignados') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-filament::page>
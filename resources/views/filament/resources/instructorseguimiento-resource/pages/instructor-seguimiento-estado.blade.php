<x-filament::page>
    <p class="text-emerald-100 dark:text-emerald-200">
        Esta tabla muestra un resumen detallado de los instructores y el estado de sus aprendices asignados. 
        Proporciona una visión general de la distribución de aprendices en diferentes etapas del proceso de formación.
    </p>
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
        

        <div class="overflow-x-auto relative">
            <table class="w-full table-auto">
                <thead class="sticky top-0 z-10 bg-emerald-100 dark:bg-emerald-800 text-emerald-700 dark:text-emerald-200 text-white" style="background-color: #39A900;">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-left text-success">Instructor</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Asignados</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Activos</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Por Certificar</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Certificados</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Retirados/Cancelados</th>
                        <th class="px-6 py-4 font-semibold text-center">Aprendices Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($this->getInstructoresData() as $instructor)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $instructor->nombres }} {{ $instructor->apellidos }}</td>
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-gray-200">{{ $instructor->total_asignados }}</td>
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-gray-200">{{ $instructor->total_activos }}</td>
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-gray-200">{{ $instructor->total_por_certificar }}</td>
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-gray-200">{{ $instructor->total_certificados }}</td>
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-gray-200">{{ $instructor->total_retirados_cancelados }}</td>
                            <td class="px-6 py-4 text-center font-semibold text-gray-900 dark:text-gray-200">{{ $instructor->total_asignados }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-emerald-50 dark:bg-emerald-900 font-bold text-emerald-800 dark:text-emerald-200 text-white" style="background-color: #04324d;">
                        <td class="px-6 py-4 whitespace-nowrap">Total</td>
                        <td class="px-6 py-4 text-center">{{ $this->getInstructoresData()->sum('total_asignados') }}</td>
                        <td class="px-6 py-4 text-center">{{ $this->getInstructoresData()->sum('total_activos') }}</td>
                        <td class="px-6 py-4 text-center">{{ $this->getInstructoresData()->sum('total_por_certificar') }}</td>
                        <td class="px-6 py-4 text-center">{{ $this->getInstructoresData()->sum('total_certificados') }}</td>
                        <td class="px-6 py-4 text-center">{{ $this->getInstructoresData()->sum('total_retirados_cancelados') }}</td>
                        <td class="px-6 py-4 text-center font-semibold">{{ $this->getInstructoresData()->sum('total_asignados') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-filament::page>
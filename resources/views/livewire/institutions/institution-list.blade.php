<div>
    <h1 class="text-xl font-semibold mb-1">Institutions</h1>
    <nav class="text-xs text-slate-400 mb-6">Dashboard / Institutions (Super Admin)</nav>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 dark:bg-slate-700/50 text-left text-slate-400">
                <tr>
                    <th class="py-3 px-4">Code</th>
                    <th class="px-4">Name</th>
                    <th class="px-4">Type</th>
                    <th class="px-4">Status</th>
                    <th class="px-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($institutions as $inst)
                <tr class="border-t border-slate-50 dark:border-slate-700">
                    <td class="py-3 px-4 font-medium text-indigo-600">{{ $inst->institution_code }}</td>
                    <td class="px-4">{{ $inst->name_en }}</td>
                    <td class="px-4">{{ ucfirst($inst->type) }}</td>
                    <td class="px-4">
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $inst->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-500' }}">
                            {{ ucfirst($inst->status) }}
                        </span>
                    </td>
                    <td class="px-4 text-right space-x-2">
                        @can('institution.suspend')
                            @if ($inst->status === 'active')
                            <button wire:click="suspend({{ $inst->id }})" class="text-red-500 hover:underline text-xs">Suspend</button>
                            @endif
                        @endcan
                        @can('institution.activate')
                            @if ($inst->status === 'suspended')
                            <button wire:click="activate({{ $inst->id }})" class="text-emerald-500 hover:underline text-xs">Activate</button>
                            @endif
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-8 text-center text-slate-400">No institutions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $institutions->links() }}</div>
    </div>
</div>

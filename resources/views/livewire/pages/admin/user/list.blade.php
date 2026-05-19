<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\User;

new class extends Component {
    use WithPagination;

    public string $search = '';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function with(): array
    {
        $query = User::query()->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        return [
            'users' => $query->paginate(10),
        ];
    }

    public function rendering($view)
    {
        return $view->layout('dashboard.index')->section('content');
    }
}; ?>

<div class="font-['DM_Sans',sans-serif]">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-5 h-0.5 bg-orange-500 inline-block"></span>
                <span class="font-['Syne',sans-serif] text-[10px] font-bold tracking-[0.18em] uppercase text-orange-500">Administration</span>
            </div>
            <h1 class="font-['Bebas_Neue',sans-serif] text-3xl tracking-wider text-gray-900 leading-none">Équipe & Utilisateurs</h1>
        </div>

        <a href="{{ route('user.create') }}" class="flex items-center justify-center gap-2 bg-orange-500 text-white px-5 py-2 rounded-sm font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-[#EA580C] transition-all shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajouter
        </a>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke-width="2" stroke-linecap="round"/></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text"
                placeholder="Rechercher (nom, email)..."
                class="w-full pl-9 pr-4 py-2 bg-white rounded-sm border border-[#E8EAF0] text-xs text-gray-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all placeholder-gray-400">
        </div>
    </div>

    <div class="bg-white rounded-sm shadow-xs border border-[#E8EAF0] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left border-collapse">
                <thead class="bg-[#F5F6FA] border-b border-[#E8EAF0]">
                    <tr>
                        <th class="px-5 py-3 font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Utilisateur</th>
                        <th class="px-3 py-3 font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Email</th>
                        <th class="px-3 py-3 font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Création</th>
                        <th class="px-5 py-3 text-right font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8EAF0]/60">
                    @forelse ($users as $user)
                        <tr class="hover:bg-[#FFF7ED] transition-colors" wire:key="{{ $user->id }}">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-sm bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center flex-shrink-0 text-white font-['Syne',sans-serif] font-bold text-[10px]">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-['Syne',sans-serif] font-bold text-gray-800 uppercase tracking-wide text-[11px]">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                <span class="text-gray-500">{{ $user->email }}</span>
                            </td>
                            <td class="px-3 py-3 text-gray-400">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex justify-end gap-1.5">
                                    <a href="{{ route('user.edit', $user) }}" class="p-1.5 text-gray-400 hover:text-orange-500 hover:bg-orange-50 rounded-sm transition-all" title="Éditer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-gray-500 text-xs">
                                Aucun utilisateur trouvé. <a href="{{ route('user.create') }}" class="text-orange-500 font-bold hover:underline">Ajoutez votre premier collaborateur.</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-5 py-3 bg-[#F5F6FA] border-t border-[#E8EAF0]">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

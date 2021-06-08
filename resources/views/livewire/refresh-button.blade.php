<div>
    <button type="button" wire:click="refresh" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <span wire:loading.remove>
            {{ $count . ' '. Str::plural('School', $count) }}
        </span>

        <span wire:loading>
            Syncing...
        </span>
    </button>
</div>

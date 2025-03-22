<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use App\Models\Category;

new class extends Component {

    public $name = '';
    
    protected function rules()
    {
        return [
            'name' => [
                'required',
                'min:3',
                Rule::unique('categories')
                    ->where(fn (Builder $query) => $query->where('user_id', Auth::user()->id))
            ]
        ];
    }

    public function addCategory()
    {
        sleep(1);
        $this->validate();
 
        Category::create([
            'user_id' => Auth::user()->id,
            'name' => $this->name
        ]);
        
        session()->flash('status', 'The category created successfully.');
        $this->reset('name'); 
    }

    public function refreshForm()
    {
        $this->resetValidation();
        $this->reset('name'); 
    }
};
?>
<div x-data="addCategory">
    <x-auth-session-status status="{{ session('status') }}" class="mb-4"></x-auth-session-status>
    <form wire:submit="addCategory" x-on:submit-category-modal.window="submitForm" x-on:hide-category-modal.window="refreshForm">
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" wire:model="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type category name" required="">
                @error('name')
                    <div class="mt-2 text-red-600">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </form>
</div>
@script
<script>
Alpine.data('addCategory', () => ({
    init() {
        //console.log('component loaded.');
    },
    destroy() {
        //console.log('component destroyed.')
    },
    submitForm() {
        $wire.addCategory().then(response => {
            this.$dispatch('category-created')
        });
    },
    refreshForm() {
        $wire.refreshForm();
    },
}));
</script>
@endscript


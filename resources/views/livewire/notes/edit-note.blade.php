<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Note') }}
    </h2>
</x-slot>
<div class="py-12" x-data x-on:hide-category-modal.window="$wire.$refresh()">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-auth-session-status status="{{ session('status') }}" class="mb-4"></x-auth-session-status>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">

                <form wire:submit="save">
                    <div>
                        <label for="title" class="block font-medium text-sm text-gray-700">Title</label>
                        <input id="title" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" wire:model="form.title" />
                        @error('form.title')
                            <span class="mt-2 text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="content" class="block font-medium text-sm text-gray-700">Content</label>
                        <textarea id="content" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" wire:model="form.content"></textarea>
                        @error('form.content')
                            <span class="mt-2 text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="category_id">Category</label>
                        <select wire:model="form.category_id" id="category" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">--}}
                            <option value="">-- Choose category --</option>
                            @foreach($categories as $category)
                                @if ($form->category_id == $category->id)
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('form.category_id')
                            <span class="mt-2 text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <x-category.add-category-modal />
                    <button class="mt-4 px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Save
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

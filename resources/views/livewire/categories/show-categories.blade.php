<div>
    <x-auth-session-status status="{{ session('status') }}" class="mt-4 mb-4"></x-auth-session-status>
    <div class="flex justify-between mb-4">
        <div class="space-x-8">
            <input wire:model.live="search" type="search" id="search" placeholder="Search...">
        </div>
        <a wire:navigate href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest">
            Add category
        </a>
    </div>
    <div class="text-red-600" wire:loading>Loading...</div>
    <div class="min-w-full align-middle">
        <table class="min-w-full divide-y divide-gray-200 border">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</span>
                            <a
                                href="#"
                                wire:click.prevent="sort('id', 'desc')"
                                @class([
                                    'text-blue-600' => ($sortBy === 'id' && $sortDirection === 'asc'),
                                    'hidden' => ($sortBy === 'id' && $sortDirection !== '' && $sortDirection !== 'asc'),
                                ])
                            >&uarr;</a>
                            <a
                                href="#"
                                wire:click.prevent="sort('id', 'asc')"
                                @class([
                                    'text-blue-600' => ($sortBy === 'id' && $sortDirection === 'desc'),
                                    'hidden' => ($sortBy === 'id' && $sortDirection !== '' && $sortDirection !== 'desc'),
                                ])
                            >&darr;</a>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</span>
                        <div class="select-none">
                            <a
                                href="#"
                                wire:click.prevent="sort('name', 'desc')"
                                @class([
                                    'text-blue-600' => ($sortBy === 'name' && $sortDirection === 'asc'),
                                    'hidden' => ($sortBy === 'name' && $sortDirection !== '' && $sortDirection !== 'asc'),
                                ])
                            >&uarr;</a>
                            <a
                                href="#"
                                wire:click.prevent="sort('name', 'asc')"
                                @class([
                                    'text-blue-600' => ($sortBy === 'name' && $sortDirection === 'desc'),
                                    'hidden' => ($sortBy === 'name' && $sortDirection !== '' && $sortDirection !== 'desc'),
                                ])
                            >&darr;</a>
                        </div>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Created at</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Updated at</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                @foreach($categories as $category)
                <tr class="bg-white">
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ $category->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ $category->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ $category->created_at }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ $category->updated_at }}
                    </td>
                    <td>
                        <a
                            href="{{ route('categories.edit', ['category' => $category->id]) }}"
                            wire:navigate
                            class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest"
                        >
                            Edit
                        </a>
                        <a
                            href="#"
                            wire:click.prevent="deleteCategory({{ $category->id }})"
                            wire:confirm="Are you sure you want to delete this category #{{ $category->id }}?"
                            class="inline-flex items-center px-4 py-2 bg-red-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest"
                        >
                            Delete
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>

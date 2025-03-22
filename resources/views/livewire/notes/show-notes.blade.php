<div>
    <x-auth-session-status status="{{ session('status') }}" class="mt-4 mb-4"></x-auth-session-status>
    <div class="flex justify-between mb-4">
        <div class="flex space-x-8 me-4">
            <div>
                <input wire:model.live="search_global" type="search" id="search" class="border-gray-300 rounded-md shadow-sm" placeholder="Search...">
            </div>
            <div>
                <select wire:model.live="search_category" id="category" class="block w-full border-gray-300 rounded-md shadow-sm">--}}
                    <option value="">-- all categories --</option>
                    @foreach($categoryList as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <a wire:navigate href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest">
            Add note
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
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</span>
                        <div class="select-none">
                            <a
                                href="#"
                                wire:click.prevent="sort('title', 'desc')"
                                @class([
                                    'text-blue-600' => ($sortBy === 'title' && $sortDirection === 'asc'),
                                    'hidden' => ($sortBy === 'title' && $sortDirection !== '' && $sortDirection !== 'asc'),
                                ])
                            >&uarr;</a>
                            <a
                                href="#"
                                wire:click.prevent="sort('title', 'asc')"
                                @class([
                                    'text-blue-600' => ($sortBy === 'title' && $sortDirection === 'desc'),
                                    'hidden' => ($sortBy === 'title' && $sortDirection !== '' && $sortDirection !== 'desc'),
                                ])
                            >&darr;</a>
                        </div>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Category</span>
                        <div class="select-none">
                            <a
                                href="#"
                                wire:click.prevent="sort('category_name', 'desc')"
                                @class([
                                    'text-blue-600' => ($sortBy === 'category_name' && $sortDirection === 'asc'),
                                    'hidden' => ($sortBy === 'category_name' && $sortDirection !== '' && $sortDirection !== 'asc'),
                                ])
                            >&uarr;</a>
                            <a
                                href="#"
                                wire:click.prevent="sort('category_name', 'asc')"
                                @class([
                                    'text-blue-600' => ($sortBy === 'category_name' && $sortDirection === 'desc'),
                                    'hidden' => ($sortBy === 'category_name' && $sortDirection !== '' && $sortDirection !== 'desc'),
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
                @foreach($notes as $note)
                <tr class="bg-white">
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ $note->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ $note->title }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ $note->category_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ $note->created_at }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ $note->updated_at }}
                    </td>
                    <td>
                        <a
                            href="{{ route('notes.edit', ['note' => $note->id]) }}"
                            wire:navigate
                            class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest"
                        >
                            Edit
                        </a>
                        <a
                            href="#"
                            wire:click.prevent="deleteNote({{ $note->id }})"
                            wire:confirm="Are you sure you want to delete this note #{{ $note->id }}?"
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
        {{ $notes->links() }}
    </div>
</div>

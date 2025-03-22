<div>
    <div class="mt-2 text-right" x-data>
        <a href="#" x-on:click.prevent="$dispatch('click-add-category-button')" class="text-blue-600 underline">Add new category</a>
    </div>
    @teleport('body')
    <div>
        <div x-data="categoryModal" x-on:category-created.window="disableLoading" x-on:click-add-category-button.window="showModal">
            <div
                id="category-modal"
                tabindex="-1"
                aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
            >
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Create new category
                            </h3>
                            <button type="button" x-show="!isLoading" x-on:click.prevent="hideModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5">
                            <livewire:categories.add-category />
                        </div>
                        <!-- Modal footer -->
                        <template x-if="isLoading">
                            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <span
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Processing...
                                </span>
                            </div>
                        </template>
                        <template x-if="!isLoading">
                            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <a href="#" role="button"
                                    x-on:click.prevent="submitModalForm"
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Add new category
                                </a>
                                <a href="#" x-on:click.prevent="hideModal"
                                   role="button"
                                   class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                >Close</a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endteleport
</div>
@script
<script>
Alpine.data('categoryModal', () => ({
    isLoading: false,
    
    init() {
        // set the modal menu element
        const $targetEl = document.getElementById('category-modal');
        
        const alp = this;

        // options with default values
        const options = {
            placement: 'center-center',
            backdrop: 'static',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: false,
            onHide: () => {
                //console.log('modal is hidden');

                alp.isLoading = false;

                alp.$dispatch('hide-category-modal');
            },
            onShow: () => {
                //console.log('modal is shown');
            },
            onToggle: () => {
                //console.log('modal has been toggled');
            },
        };

        const modal = new Modal($targetEl, options);
    },
    destroy() {
        //console.log('destroy')
        let modal = FlowbiteInstances.getInstance('Modal', 'category-modal');
        modal.destroyAndRemoveInstance();
    },

    showModal() {
        const modal = FlowbiteInstances.getInstance('Modal', 'category-modal');
        if (modal) {
            // show the modal
            modal.show();
        }
    },

    hideModal() {
        const modal = FlowbiteInstances.getInstance('Modal', 'category-modal');
        modal.hide();

        //this.isLoading = false;
        
        //this.$dispatch('hide-category-modal');
    },
    submitModalForm() {
        this.isLoading = true;
        this.$dispatch('submit-category-modal')
    },
    disableLoading() {
        this.isLoading = false;
    },
    
}));
</script>
@endscript


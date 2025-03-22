<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

use App\Livewire\Traits\WithSorting;

class ShowCategories extends Component
{
    use WithPagination, WithSorting;
    
    #[Url]
    public string $search = '';

    #[Url(except: '')]
    public $sortBy = '';
    
    #[Url(except: '')]
    public $sortDirection = '';

    public function updating($property): void
    {
        if ($property === 'search') {
            $this->resetPage();
        }
    }
    
    public function sort($sort, $direction)
    {
        $this->sortBy = $sort;
        $this->sortDirection = $direction;
    }

    public function deleteCategory(int $id)
    {
        $category = Category::findOrFail($id);
        
        if (Auth::user()->id !== $category->user_id) {
            session()->flash('status', 'Invalid category.');
            return $this->redirectRoute('categories.index', navigate: true);
        }
        
        if ($category->notes()->count() > 0) {
            session()->flash('status', __('The category was not deleted. The category has notes.'));
            return;
        }
        
        $category->delete();
    }
    
    public function render(): View
    {
        //emulate the delay
        sleep(1);
        
        $sortBy = $this->sortBy;
        $sortDirection = $this->sortDirection;
        
        if (empty($sortBy)) {
            $sortBy = 'id';
        }
        
        if (empty($sortDirection)) {
            $sortDirection = 'asc';
        }
        
        if (!in_array($sortBy, ['id', 'name', 'created_at', 'updated_at'])) {
            $sortBy = 'id';
        }
        
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $categories = Auth::user()->categories()
            ->when($this->search !== '', function (Builder $query) {
                $query->whereAny([
                    'id',
                    'name',
                    ], 'like', '%' . $this->search . '%');
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(5);

        return view('livewire.categories.show-categories', [
            'categories' => $categories,
        ]);
    }

    public function render_2(): View
    {
//        sleep(1);
//        $products = Product::with('category')
        $products = Product::with('categories')
            ->when($this->searchQuery !== '', fn(Builder $query) => $query->where('name', 'like', '%'. $this->searchQuery .'%'))
//            ->when($this->searchCategory > 0, fn(Builder $query) => $query->where('category_id', $this->searchCategory))
            ->when($this->searchCategory > 0, function (Builder $query) {
                $query->whereHas('categories', function (Builder $query2) {
                    $query2->where('id', $this->searchCategory);
                });
            })
            ->paginate(10);

        return view('livewire.categories.show-categories', [
            'products' => $products,
        ]);
    }
    
}

<?php

namespace App\Livewire\Notes;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use App\Models\Note;
use App\Livewire\Traits\WithSorting;

class ShowNotes extends Component
{
    use WithPagination, WithSorting;
    
    #[Url(except: '')]
    public string $search_global = '';
    
    #[Url(except: '')]
    public $search_category = '';

    #[Url(except: '')]
    public $sortBy = '';
    
    #[Url(except: '')]
    public $sortDirection = '';

    public function updating($property): void
    {
        if ($property === 'search_global' || $property === 'search_category') {
            $this->resetPage();
        }
    }
    
    public function sort($sort, $direction)
    {
        $this->sortBy = $sort;
        $this->sortDirection = $direction;
    }

    public function deleteNote(int $id)
    {
        $note = Note::findOrFail($id);
        
        if (Auth::user()->id !== $note->user_id) {
            session()->flash('status', 'Invalid note.');
            return $this->redirectRoute('notes.index', navigate: true);
        }
        
        $note->delete();
        session()->flash('status', 'The note deleted successfully.');
    }
    
    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
            <div>Loading ...</div>
        </div>
        HTML;
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
        
        if (!in_array($sortBy, ['id', 'title', 'category_name', 'created_at', 'updated_at'])) {
            $sortBy = 'id';
        }
        
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }
        
        $notes = Auth::user()->notes();

        $notes = $notes->join('categories', 'notes.category_id', '=', 'categories.id')
            ->select('notes.*', 'categories.name as category_name')
            ->when($this->search_category > 0, function (Builder $query) {
                $query->where('category_id', $this->search_category);
            })
            /*
            ->when($this->search_id, function (Builder $query) {
                $query->where('notes.id', $this->search_id);
            })
            ->when($this->search_title, function (Builder $query) {
                $query->where('title', 'like', '%' . $this->search_title . '%');
            })
            ->when($this->search_content, function (Builder $query) {
                $query->where('content', 'like', '%' . $this->search_content . '%');
            })
             * 
             */
            ->when($this->search_global !== '', function (Builder $query) {
                $query->whereAny([
                    'notes.id',
                    'title',
                    'content',
                    ], 'like', '%' . $this->search_global . '%');
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(5);
        
        $categoryList = Auth::user()->categories()
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.notes.show-notes', [
            'notes' => $notes,
            'categoryList' => $categoryList
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

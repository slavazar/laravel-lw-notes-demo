<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\CategoryForm;
use App\Models\Category;

#[Layout('layouts.app')] 
class EditCategory extends Component
{
    public CategoryForm $form; 
    
    public function mount(Category $category)
    {
        if (Auth::user()->id !== $category->user_id) {
            session()->flash('status', 'Invalid category.');
            $this->redirectRoute('categories.index', navigate: true);
        }
        
        $this->form->setCategory($category);
    }
    

    public function save(): void
    {
        $this->form->update();
        session()->flash('status', 'The category updated successfully.');
    }
    
    public function render(): View
    {
        return view('livewire.categories.edit-category', [
        ]);
    }
    
}

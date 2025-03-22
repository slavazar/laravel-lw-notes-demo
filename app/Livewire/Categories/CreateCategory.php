<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\CategoryForm;
use App\Models\Category;

#[Layout('layouts.app')] 
class CreateCategory extends Component
{
    public CategoryForm $form; 
 
    public function save()
    {
        $this->form->save(); 
 
        session()->flash('status', 'The category created successfully.');
        return $this->redirectRoute('categories.edit', ['category' => $this->form->category], navigate: true);
    }
    
    public function render(): View
    {
        return view('livewire.categories.create-category', [
        ]);
    }
    
}

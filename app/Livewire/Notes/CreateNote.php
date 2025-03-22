<?php

namespace App\Livewire\Notes;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\NoteForm;

class CreateNote extends Component
{
    public NoteForm $form;
    
    public function mount()
    {
    }
 
    public function save()
    {
        $this->form->save(); 
 
        session()->flash('status', 'The note created successfully.');
        return $this->redirectRoute('notes.edit', ['note' => $this->form->note], navigate: true);
    }
    
    public function render(): View
    {
        $categories = Auth::user()->categories()
            ->orderBy('name', 'asc')
            ->get();
        
        return view('livewire.notes.create-note', [
            'categories' => $categories
        ]);
    }
    
}

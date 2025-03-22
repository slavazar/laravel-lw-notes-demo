<?php

namespace App\Livewire\Notes;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\NoteForm;
use App\Models\Note;
use App\Models\Category;

class EditNote extends Component
{
    public NoteForm $form;
    
    //public $categories;
    
    public function mount(Note $note)
    {
        if (Auth::user()->id !== $note->user_id) {
            session()->flash('status', 'Invalid note.');
            $this->redirectRoute('notes.index', navigate: true);
        }
        
        $this->form->setNote($note);
    }
    
    public function boot() 
    {
    }    

    public function save(): void
    {
        $this->form->update();
        session()->flash('status', 'The note updated successfully.');
    }
    
    public function render(): View
    {
        $categories = Auth::user()->categories()
            ->orderBy('name', 'asc')
            ->get();
        
        return view('livewire.notes.edit-note', [
            'categories' => $categories
        ]);
    }
    
}

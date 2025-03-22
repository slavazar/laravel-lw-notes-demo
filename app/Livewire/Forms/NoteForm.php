<?php
 
namespace App\Livewire\Forms;
 
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
 
class NoteForm extends Form
{
    public ?Note $note;

    #[Validate('required|max:100')]
    public $title = '';

    #[Validate('required|min:3|max:500')]
    public $content = '';

    #[Validate('required|integer')]
    public $category_id;
    
    public function setNote(Note $note): void
    {
        $this->note = $note;
        
        $this->title = $note->title;
        $this->content = $note->content;
        $this->category_id = $note->category_id;
    }

    public function save(): void
    {
        $this->validate();
 
        $note = Note::create([
            'user_id' => Auth::user()->id,
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => $this->category_id,
        ]);
        
        $this->note = $note;
    }

    public function update(): void
    {
        $this->validate();

        $this->note->update($this->all());
    }    
}

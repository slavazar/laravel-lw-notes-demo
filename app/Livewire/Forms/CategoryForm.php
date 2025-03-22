<?php
 
namespace App\Livewire\Forms;
 
//use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use App\Models\Category;
 
class CategoryForm extends Form
{
    public ?Category $category;

    public $name = '';
    
    protected function rules()
    {
        $uniqRule = Rule::unique('categories')
            ->where(fn (Builder $query) => $query->where('user_id', Auth::user()->id));
        
        if (isset($this->category)) {
            $uniqRule = $uniqRule->ignore($this->category);
        }

        return [
            'name' => [
                'required',
                'min:3',
                $uniqRule

            ],
        ];
    }
    
    protected function rules_2()
    {
        if (isset($this->category)) {
            return [
                'name' => [
                    'required',
                    'min:3',
                    Rule::unique('categories')
                        ->where(fn (Builder $query) => $query->where('user_id', Auth::user()->id))
                        ->ignore($this->category),

                ],
            ];
        } else {
            return [
                'name' => [
                    'required',
                    'min:3',
                    Rule::unique('categories')
                        ->where(fn (Builder $query) => $query->where('user_id', Auth::user()->id))
                ],
            ];
        }
    }
    
    public function setCategory(Category $category): void
    {
        $this->category = $category;
        
        $this->name = $category->name;
    }

    public function save(): void
    {
        $this->validate();
 
        $category = Category::create([
            'user_id' => Auth::user()->id,
            'name' => $this->name
        ]);
        
        $this->category = $category;
    }

    public function update(): void
    {
        $this->validate();

        $this->category->update($this->all());
    }    
}

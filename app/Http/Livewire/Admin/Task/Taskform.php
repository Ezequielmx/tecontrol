<?php

namespace App\Http\Livewire\Admin\Task;

use App\Http\Controllers\Admin\TaskController;
use Livewire\Component;
use App\Models\Task;

class Taskform extends Component
{
    public $task;
    public $selectedColor;

    protected $listeners = ['setFecha'];

    protected $rules = [
        'task.tarea' => 'required',
        'task.fecha_ini' => 'required|date',
        'task.fecha_fin' => 'required|date|after_or_equal:task.fecha_ini',
        'task.check' => 'nullable',
        'task.color' => 'nullable'
    ];

    public function mount(Task $task = null){
        $this->task = $task;
         $this->task->color="#007bff";
    }
    
    public function render()
    {
        return view('livewire.admin.task.taskform');
    }

    public function guardar(){
        $this->validate();
        $this->task->save();
        $this->emit('cerrarModal');  
    }

    public function setFecha($fecha){
        $this->task->fecha_ini = $fecha;
        $this->task->fecha_fin = $fecha;
    }
}

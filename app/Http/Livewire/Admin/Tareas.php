<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Tarea;
use App\Models\Tareaupdate;


class Tareas extends Component
{
    public $tasks;
    public $title, $description, $value, $category = 'Personal';
    public $selectedTask, $detail;

    protected $listeners = ['abrirModal' => 'resetFields'];

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {

        $this->tasks = Tarea::withCount('updates')
            ->with('updates')
            ->orderByDesc('updated_at')
            ->get()
            ->groupBy('category')
            ->toArray(); // Convierte a array puro para evitar problemas en Livewire
        
        //dd($this->tasks);
    }

    public function saveTask()
    {
        Tarea::updateOrCreate(
            ['id' => $this->selectedTask],
            [
                'title' => $this->title,
                'description' => $this->description,
                'value' => $this->value === '' ? null : $this->value,
                'category' => $this->category
            ]
        );
        $this->resetFields();
        $this->loadTasks();
    }

    public function selectTask($taskId)
    {
        $task = Tarea::find($taskId);
        $this->selectedTask = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->value = $task->value;
        $this->category = $task->category;

        $this->dispatchBrowserEvent('abrir-modal');
    }

    public function deleteTask($taskId)
    {
        $task = Tarea::find($taskId);
        if ($task) {
            $task->delete();
            $this->loadTasks();
        }
    }

    public function addUpdate()
    {
        Tareaupdate::create([
            'task_id' => $this->selectedTask,
            'detail' => $this->detail
        ]);
        $this->detail = '';
        $this->loadTasks();
    }

    public function newTask()
    {
        $this->resetFields();
        $this->dispatchBrowserEvent('abrir-modal');
    }

    public function resetFields()
    {
        $this->selectedTask = null;
        $this->title = '';
        $this->description = '';
        $this->value = '';
        $this->category = 'Personal';
    }

    public function render()
    {
        return view('livewire.admin.tareas');
    }
}

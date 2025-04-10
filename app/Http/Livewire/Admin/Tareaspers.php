<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Tareaper;
use App\Models\Tareapersupdate;


class Tareaspers extends Component
{
    public $tasks;
    public $title, $description;
    public $selectedTask, $detail;

    protected $listeners = ['abrirModalp' => 'resetFields'];

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = Tareaper::withCount('updates')
            ->with('updates')
            ->orderByDesc('updated_at')
            ->get()
            ->toArray(); // Convierte a array puro para evitar problemas en Livewire
        
        //dd($this->tasks);
    }

    public function saveTask()
    {
        Tareaper::updateOrCreate(
            ['id' => $this->selectedTask],
            [
                'title' => $this->title,
                'description' => $this->description
            ]
        );
        $this->resetFields();
        $this->loadTasks();
    }

    public function selectTask($taskId)
    {
        $task = Tareaper::find($taskId);
        $this->selectedTask = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;

        $this->dispatchBrowserEvent('abrir-modalp');
    }

    public function deleteTask($taskId)
    {
        $task = Tareaper::find($taskId);
        if ($task) {
            $task->delete();
            $this->loadTasks();
        }
    }

    public function addUpdate()
    {
        Tareapersupdate::create([
            'tareapers_id' => $this->selectedTask,
            'detail' => $this->detail
        ]);
        $this->detail = '';
        $this->loadTasks();
    }

    public function newTask()
    {
        $this->resetFields();
        $this->dispatchBrowserEvent('abrir-modalp');
    }

    public function resetFields()
    {
        $this->selectedTask = null;
        $this->title = '';
        $this->description = '';
    }

    public function render()
    {
        return view('livewire.admin.tareaspers');
    }
}
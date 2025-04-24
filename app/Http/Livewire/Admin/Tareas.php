<?php

namespace App\Http\Livewire\Admin;

use App\Models\Client;
use Livewire\Component;
use App\Models\Tarea;
use App\Models\Tareaupdate;
use App\Models\Quotation;


class Tareas extends Component
{
    public $quotations;
    public $quotationsClient;
    public $selectedClient;
    public $clients;
    public $tasks;
    public $title, $description, $quotation_id;
    public $selectedTask, $detail;

    public $taskTotal = 0;

    //protected $listeners = ['abrirModal' => 'resetFields'];

    public function mount()
    {
        $this->loadTasks();

        $this->quotations = Quotation::orderByDesc('nro')->get();
        $this->quotationsClient = Quotation::orderByDesc('nro')->get();
        $this->clients = Quotation::with('client')
            ->get()
            ->map(fn($q) => $q->client)
            ->filter() // 👈 filtra los null
            ->unique('id')
            ->sortBy('razon_social') // 👈 ordena por razon_social
            ->values();
    }

    public function render()
    {
        //dd($this->tasks);
        return view('livewire.admin.tareas');
    }

    public function loadTasks()
    {
        $this->tasks = Tarea::withCount('updates')
            ->with('updates')
            ->orderByDesc('updated_at')
            ->get()
            ->toArray(); // Convierte a array puro para evitar problemas en Livewire

            $this->taskTotal = array_reduce($this->tasks, function ($carry, $task) {
                if (isset($task['quotation_id'])) {
                    $quotation = Quotation::find($task['quotation_id']);
                    if ($quotation) {
                        $carry += $quotation->total();
                    }
                }
                return $carry;
            }, 0);

    }

    public function saveTask()
    {
        Tarea::updateOrCreate(
            ['id' => $this->selectedTask],
            [
                'title' => $this->title,
                'description' => $this->description,
                'quotation_id' => $this->quotation_id ?: null
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
        $this->quotation_id = $task->quotation_id;
        $this->selectedClient = Quotation::find($task->quotation_id)?->client_id;
        $this->quotationsClient = Quotation::where('client_id', $this->selectedClient)
            ->orderByDesc('nro')
            ->get();


        $this->dispatchBrowserEvent('abrir-modal');
    }

    public function updatedSelectedClient($clientId)
    {
        $this->quotationsClient = Quotation::where('client_id', $clientId)
            ->orderByDesc('nro')
            ->get();

        $this->quotation_id = null;

        //dd($this->tasks);
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

    public function deleteUpdateFromTask($updateId)
    {
        $update = TareaUpdate::find($updateId);
    
        if ($update) {
            $update->delete();
            $this->loadTasks(); // Recargar tareas con updates actualizados
        }
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
        $this->quotation_id = null;
        $this->detail = '';
        $this->selectedClient = null;
        $this->quotationsClient = Quotation::orderByDesc('nro')->get();
        $this->quotations = Quotation::orderByDesc('nro')->get();
    }
}

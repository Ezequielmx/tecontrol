<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\ClientsSector;

class EditClientsForm extends Component
{
    public $client;
    public $selectedClientId;
    public $newSector;

    protected $listeners = [
        'loadClient' => 'loadClient',
        'loadClientConf' => 'loadClientConf'
    ];

    protected $rules = [
        'client.razon_social' => 'required',
        'client.tipo_cliente' => 'required',
        'client.cuit' => 'nullable',
        'client.direccion' => 'nullable|max:255',
        'client.telefono' => 'nullable|max:255',
        'client.condicion' => 'nullable|max:255',
        'client.observaciones' => 'nullable',
    ];

    public function mount()
    {
        $this->client = new Client();
        $this->selectedClientId = null;
    }

    public function loadClient($client_id)
    { 
        $this->loadClientConf($client_id);
    }


    public function loadClientConf($client_id)
    {
        if ($client_id) {
            $this->client = Client::find($client_id);
            $this->selectedClientId = $client_id;
            $this->newSector = null;

        } else {
            $this->client = new Client();
            $this->selectedClientId = null;
            $this->newSector = null;
        }
    }

    public function render()
    {
        return view('livewire.edit-clients-form');
    }

    public function saveClient()
    {
        $this->validate();
        $this->client->save();
        $this->emit('refreshClients');
    }

    public function changeNombre( $clientsector_id, $nombre)
    {
        $clientsector = ClientsSector::find($clientsector_id);
        $clientsector->sector = $nombre;
        $clientsector->save();
    }

    public function removeSector($clientsector_id)
    {
        $clientsector = ClientsSector::find($clientsector_id);
        $clientsector->delete();
        //$this->emit('refreshClients');
    }

    public function addSector()
    {
        $clientsector = new ClientsSector();
        $clientsector->sector = $this->newSector;
        $clientsector->client_id = $this->client->id;
        $clientsector->save();
        $this->newSector = null;
        $this->emit('refreshClients');
    }
}

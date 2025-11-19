<?php

namespace App\Livewire\Param;

use Livewire\Component;

class DemandeQualificationFiliere extends Component
{
    public $datasets = [];
    public $entry = [
        "filiere" => null,
        "niveau" => null,
    ];

    public function mount()
    {
        if(isset($this->datasets[0]))
        {
            $decodeData = json_decode($this->datasets[0], true);

            if (count($decodeData['aire']) > 0) {
                $data = $decodeData['aire'][0];
                $this->datasets = [];
                array_push($this->datasets, $data);
            }
        }
    }



    public function add()
    {
        $data['filiere'] = $this->entry['filiere'];
        $data['niveau'] = $this->entry['niveau'];
        array_push($this->datasets, $data);
        $this->dispatch('qualificationFiliere', $this->datasets);
    }





    function remove(int $index)
    {

        if (isset($this->datasets[$index - 1])) {
            unset($this->datasets[$index - 1]);
            $this->datasets = array_values($this->datasets);
            return true;
        } else {
            return false;
        }
    }




    public function render()
    {
        if (count($this->datasets)) {
            $this->dispatch('qualificationFiliere', $this->datasets);
        }
        return view('livewire.param.demande-qualification-filiere');
    }
}

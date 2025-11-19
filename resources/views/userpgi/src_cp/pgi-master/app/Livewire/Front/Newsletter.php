<?php

namespace App\Livewire\Front;

use App\Models\NewslettersSuscriber;
use Livewire\Component;

class Newsletter extends Component
{
    public $email;
    public $message;
    public $correct;

    function mount()
    {
        $this->fill([
            'email' => '',
            'message' => '',
            'correct'=>false
        ]);
    }

    function updatingEmail()
    {
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $this->correct = true;
            $this->message = 'Adresse email valide';
        }
        else{
            $this->correct = false;
            $this->message = 'Adresse email invalide';
        }
    }

    function save()
    {
        $existSuscriber = NewslettersSuscriber::where('suscriber_email',$this->email)->first();

        if($existSuscriber)
        {
            $this->message = 'Cette adresse est déjà utilisée';
            return;
        }

        if(NewslettersSuscriber::create(['suscriber_email'=>$this->email]))
        {
            $this->message = 'Souscription effectuée avec succès';
            return;
        }

        /** Reload page **/
        //$this->js('window.location.reload()');
    }

    public function render()
    {
        return view('livewire.front.newsletter');
    }
}

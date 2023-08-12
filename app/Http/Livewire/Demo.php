<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;

class Demo extends Component
{
    public $svgData;
    public $count = 43;
    public $showSvg = false;
    public $selectedState;
    public $selectedCity;

    public function increment()
    {
        $this->count++;
    }

    public function toggleSvg()
    {
        if ($this->count >= 0) {
            $this->showSvg = !$this->showSvg;
            $this->increment();
        } else {
            $this->increment();
        }
    }

    public function mount()
    {
        // Load SVG data on component initialization
        $jsonFilePath = storage_path('app/svg_coordinates.json');

        if (File::exists($jsonFilePath)) {
            $this->svgData = json_decode(File::get($jsonFilePath), true);
        } else {
            $this->svgData = ['error' => 'SVG data not found'];
        }
    }

    public function render()
    {
        if ($this->count == 0) {
            $this->showSvg = false;
        }
        return view('livewire.demo');
    }

    public function updatedSelectedState()
    {
        // Reset the selected city when the state changes
        $this->selectedCity = null;
    }

    public function getCitiesProperty()
    {
        if ($this->selectedState && isset($this->svgData[$this->selectedState]['city'])) {
            return array_keys($this->svgData[$this->selectedState]['city']);
        }

        return [];
    }
    
    public function updatedSelectedCity()
    {
        // Handle the event when a city is selected
    }
}

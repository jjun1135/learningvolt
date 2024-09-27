<?php

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state(['task' => '', 'description' => '', 'urgency']);

rules(['task' => 'required|string', 'description' => 'required|string', 'urgency' => 'integer|min:1|max:10']);

$store = function () {
    $validated = $this->validate();
    auth()->user()->todos()->create($validated);
    $this->task = '';
    $this->description = '';
    $this->urgency = '';
    $this->dispatch('todos-created'); //this dispaces 'todos-created' every time a a new todo is comitted, therefore 'activated' on in todolist.blade.php
};
?>

<div>
    <form wire:submit="store" class='text-center'> 
        <h1 class='text-center scale-80 p-2'>{{ __('Task:') }}</h1>
        <input type="text" wire:model="task" placeholder="{{ __('What\'s your To-Do?') }}" class="text-center w-64 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
        <x-input-error :messages="$errors->get('task')" class="mt-2" />
        <br>
        <h1 class='text-center scale-80 p-2'>{{ __('Description:') }}</h1>
        <textarea
            wire:model="description"
            placeholder="{{ __('Describe your task and what\'s important') }}"
            class="text-center w-64 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            style="resize: none;"
        ></textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
        <br>
        <h1 class='text-center  scale-80 p-2'>{{ __('Urgency:') }}</h1>
        <input type="number" min='1' max='10' wire:model="urgency" placeholder="{{ __('How urgent is the task from 1 - 10?') }}" class=" w-64 text-center border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
        <x-input-error :messages="$errors->get('urgency')" class="mt-2" />
        <br>
        <x-primary-button class="mt-4">{{ __('Submit To-Do') }}</x-primary-button>
    </form> 
</div>

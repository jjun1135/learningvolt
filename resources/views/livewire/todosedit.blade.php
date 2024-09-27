<?php

use function Livewire\Volt\mount;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state(['todo', 'task', 'description', 'urgency']);

rules(['task' => 'required|string', 'description' => 'required|string', 'urgency' => 'required|integer|min:1|max:10']);

mount(
    fn () => [
        $this->description = $this->todo->description,
        $this->urgency = $this->todo->urgency,
        $this->task = $this->todo->task,
    ]);

$update = function () {
    $this->authorize('update', $this->todo);

    $validated = $this->validate();

    $this->todo->update($validated);

    $this->dispatch('todo-updated');
};

$cancel = fn () => $this->dispatch('todo-edit-canceled');

?>

<div>
<form wire:submit="update"> 
        <h1 class='text-center scale-80 p-2'>{{ __('Task:') }}</h1>
        <input 
            type="text" 
            wire:model='task' 
            class="text-center border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
        <x-input-error :messages="$errors->get('task')" class="mt-2" />
        
        <h1 class='text-center scale-80 p-2'>{{ __('Description:') }}</h1>
        <textarea
            wire:model="description"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />

        <h1 class='text-center scale-80 p-2'>{{ __('Urgency:') }}</h1>
        <input type="number" 
            min='1' max='10' 
            wire:model="urgency" 
            class=" w-64 text-center border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>

        <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
        <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
    </form> 
</div>

<?php

use App\Models\Todo;

use function Livewire\Volt\on;
use function Livewire\Volt\state;

$getTodos = fn () => $this->todos = Todo::with('user')->latest()->get();
// Todo::with('user') retrieves the associated data of the 'user'

state(['todos' => $getTodos, 'editing' => null]);
//this defines the todos that are looped through as $todo

$disableEditing = function () {
    $this->editing = null;

    return $this->getTodos();
};

$edit = function (Todo $todo) {
    $this->editing = $todo;

    $this->getTodos();
};

$delete = function (Todo $todo) {
    $this->authorize('delete', $todo);

    $todo->delete();

    $this->getTodos();
};

on([
    'todos-created' => $getTodos,
    'todo-updated' => $disableEditing,
    'todo-edit-canceled' => $disableEditing,
]);
// on() listens to an even here 'todos-created'. If this event is triggered, then the method '$getTodos()' form above is called

?>

<div class="mt-6 bg-white shadow-sm rounded-lg divide-y"> 
    @foreach ($todos as $todo)
        <div class="p-0.05 flex space-x-2" wire:key="{{ $todo->id }}">
            <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="p-2">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-gray-800">{{ $todo->user->name }}</span>
                        <small class="ml-2 text-sm text-gray-600">{{ $todo->created_at->format('j M Y, g:i a') }}</small> <br>
                        <input type="checkbox" id='checkbox_urgency'>
                        <label for="checkbox_urgency">Done</label>
                        @unless ($todo->created_at->eq($todo->updated_at))
                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                        @endunless
                    </div>
                    @if ($todo->user->is(auth()->user()))
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link wire:click="edit({{ $todo->id }})">
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <x-dropdown-link wire:click="delete({{ $todo->id }})" wire:confirm="Are you sure to delete this chirp?"> 
                                    {{ __('Delete') }}
                                </x-dropdown-link> 
                            </x-slot>
                        </x-dropdown>
                    @endif
                </div>
                @if ($todo->is($editing)) 
                    <livewire:todosedit :todo="$todo" :key="$todo->id" />
                @else
                    <p class="p-1 text-lg text-gray-900">Task: {{ $todo->task }}</p>
                    <p class="p-1 text-lg text-gray-900">Description: {{ $todo->description }}</p>
                    <p class="p-1 text-lg text-gray-900">Urgency: {{ $todo->urgency }}</p>
                @endif

            </div>
        </div>
    @endforeach 
</div>

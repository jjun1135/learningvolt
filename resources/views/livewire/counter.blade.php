<?php

use function Livewire\Volt\state;

state(['count' => 0]);

$increment = fn () => $this->count++;
$decrement = fn () => $this->count--;

?>
<div>
    <div>
        <h1 class='text-center scale-150 p-4'>{{ $count }}</h1>
    </div>
    <div class='text-center scale-150 p-4'>
        <button wire:click="increment" class="bg-green-400 text-white font-bold py-1 px-3 rounded-full">+</button>
        <button wire:click="decrement" class="bg-red-400 text-white font-bold py-1 px-3 rounded-full">-</button>
    </div>
</div>

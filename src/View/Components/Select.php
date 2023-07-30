<?php

namespace Mary\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    public string $uuid;

    public function __construct(
        public string $name = '',
        public string $label = '',
        public string $icon = '',
        public string $placeholder = '---',
        public string $key = 'id',
        public string $value = 'name',
        public Collection $options = new Collection(),
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div wire:key="{{ $uuid }}">
                <label class="label label-text font-semibold">{{ $label }}</label>
                    <div class="relative">
                    @if($icon)
                        @svg($icon, 'mt-3 ml-3 h-5 h-5 text-gray-400 absolute')                        
                    @endif
                    <select {{ $attributes}} {{ $attributes->class(['select select-primary w-full font-normal', 'pl-10' => $icon]) }}>
                        <option value="">{{ $placeholder }}</option>
                        @foreach ($options as $option)
                            <option value="{{ $option->$key }}">{{ $option->$value }}</option>
                        @endforeach
                    </select>
                </div>
                @error($name)
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        HTML;
    }
}
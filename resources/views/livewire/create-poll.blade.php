<div>
    <form wire:submit.prevent="createPoll">
        <label for="">Poll Title</label>
        <input type="text" name="" id="" wire:model.live="title" />
        current title: {{ $title }}  

        <div class="mt-4 mb-4">
{{-- wire:click.prevent="addOption": Kullanıcının "Add Option" düğmesine tıkladığında, addOption() yönteminin çağrılmasını sağlar ve sayfanın yeniden yüklenmesini engeller. --}}
            <button class="btn" wire:click.prevent="addOption">Add Option</button>
        </div>

        <div>
            @foreach ($options as $index => $option)
                <div class="mb-4">
                    <label for=""> Option {{ $index+1 }}</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model="options.{{$index}}"/>
                        <button class="btn" wire:click.prevent="removeOption({{$index}})" >Remove</button>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn">Create Poll</button>
    </form>
</div>

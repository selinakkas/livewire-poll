<?php

namespace App\Livewire;

use \App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{
    //Anket seçeneklerini saklamak için bir dizi
    public $title;
    public $options = ['first'];

    protected $rules = [
        "title" => "required|min:3|max:255",
        "options" => "required|array|min:1|max:10",
        "options.*" => "required|min:1|max:255"
    ];

    protected $messages =[
        "options.*"=> "The option cannot be empty"
    ];

    //render(): Livewire bileşeninin görünümünü oluşturmak için kullanılır. 
    public function render()
    {
        return view('livewire.create-poll');
    }

    //Bu işlev, kullanıcı bir seçenek eklemek istediğinde çağrılır. 
    //Yeni bir boş dize, options dizisine eklenir, böylece kullanıcı daha fazla seçenek girebilir.
    public function addOption()
    {
        $this->options[] = "";
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        //bu komut option sildiğimizde option numaralarını kaydırmaz. örneğin 4 option inputumuz olsun bunların labelı option1,option2,option3,option4 biz eğer option3ü silersek option1,option2,option3 olarak gözükür bu komut çalışmazsa option1,option2,option4 olarak gözükür
        $this->options = array_values($this->options);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createPoll()
    {
        $this->validate();

        $poll=Poll::create([
            "title"=> $this->title
        ])->options()->createMany(
            collect($this->options)
            ->map(fn($option) =>['name'=>$option])
            ->all()
        );

        // foreach( $this->options as $optionName ) 
        // {
        //     $poll->options()->create(['name' => $optionName]);
        // }

        $this->reset(['title','options']);
        $this->emit('pollCreated');
    }
}



// İşlevlerin çalışma mantığı şu şekildedir:

// Kullanıcı sayfayı ilk açtığında, render() işlevi çalışır ve livewire.create-poll.blade.php görünümü oluşturulur.
// Kullanıcı "addOption" butonuna tıkladığında, JavaScript tarafında bir istek oluşturulur ve "addOption" işlevi çağrılır.
// "addOption" işlevi, "options" dizisine yeni bir boş dize ekler.
// Sayfanın yeniden yüklenmesi gerekmez, çünkü Livewire dinamik olarak kullanıcı arayüzünü günceller ve yeni seçenek alanı otomatik olarak görüntülenir.
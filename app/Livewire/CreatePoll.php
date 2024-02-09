<?php

namespace App\Livewire;

use \App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{
    //Anket seçeneklerini saklamak için bir dizi
    public $title;
    public $options = [];

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

    public function createPoll()
    {
        $poll=Poll::create([
            "title"=> $this->title
        ]);

        foreach( $this->options as $optionName ) 
        {
            $poll->options()->create(['name' => $optionName]);
        }

        $this->reset(['title','options']);
    }
}



// İşlevlerin çalışma mantığı şu şekildedir:

// Kullanıcı sayfayı ilk açtığında, render() işlevi çalışır ve livewire.create-poll.blade.php görünümü oluşturulur.
// Kullanıcı "addOption" butonuna tıkladığında, JavaScript tarafında bir istek oluşturulur ve "addOption" işlevi çağrılır.
// "addOption" işlevi, "options" dizisine yeni bir boş dize ekler.
// Sayfanın yeniden yüklenmesi gerekmez, çünkü Livewire dinamik olarak kullanıcı arayüzünü günceller ve yeni seçenek alanı otomatik olarak görüntülenir.
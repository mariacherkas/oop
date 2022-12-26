<?php

class Tag{
    public string $name;
    public array $attributes;

    public function __construct($name){
        $this->name = $name;
        $this->attributes = [];
    }

    public function attr($name, $value = ''){
        $this->attributes[$name] = $value;
        return $this;
    }

    public function tag(){
        $attributes = $this->renderAttributes();
        $tag = "&lt;$this->name $attributes&gt;";
        return $tag;
    }

    public function renderAttributes(){
        $attributes = '';
        if(count($this->attributes)){
            foreach($this->attributes as $key => $item){
                $attributes .= ' ' . $key . ' = "' . $item . '"';
            }
        }
        return $attributes;
    }
}

class SingleTag extends Tag{

}

class PairTag extends Tag{ 
    public array $childs = array();


    public function appendChild($child){
            array_push($this->childs, $child);
            return $this;
    }



    public function tagChild(){
        return implode(' ', array_map(function (Tag $child){
            return $child->tag();
        }, $this->childs));
    }

    public function tag(){
        $tag = parent::tag();
        $tag .= $this->tagChild();
        $tag .= "&lt;/$this->name&gt;";
        return $tag;
    }
}

$hr = new SingleTag('hr');

$a = new PairTag('a');
$a->attr("src", "erer");
$hr->attr("width", "100px");

$a->appendChild($hr);

echo $a->tag();
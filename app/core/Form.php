<?php
namespace core\HTML;

class Form{

    private $data;

    public function __construct($data = []){
        $this->data = $data;
    }

    private function getValue($index){
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    private function getLabel($label, $name){
        return "<label for=\"" . $name ."\" class=\"col-sm-3 control-label\">$label</label>";
    }

    private function surround($html){
        return "<div class=\"form-group\">$html</div>";
    }

    public function input($label, $name){
        return $this->surround($this->getLabel($label, $name) . "
        <div class=\"col-sm-8\">
        <input type='text' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' />
        </div>");
    }

    public function password($label, $name){
        return $this->surround($this->getLabel($label, $name) . "
        <div class=\"col-sm-8\">
        <input type='password' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' />
        </div>");
    }

    public function email($label, $name){
        return $this->surround($this->getLabel($label, $name) . "
        <div class=\"col-sm-8\">
        <input type='email' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' />
        </div>");
    }

    public function submit($texte){
        return $this->surround("<div class=\"col-sm-offset-3 col-sm-9\">
                    <button type=\"submit\" class=\"btn btn-default\">$texte</button>
                </div>");
    }

    public function lien($lien, $texte){
        return $this->surround('<div class="col-sm-offset-2 col-sm-10">
                    <a href="' .$lien .'" class="body-form-lien">' . $texte .'</a>
                </div>');
    }
}
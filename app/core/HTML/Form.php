<?php
namespace core\HTML;

class Form{

    private $data;

    public function __construct($data = []){
        $this->data = $data;
    }

    /**
     * @param $index
     * @return null|string
     */
    private function getValue($index){
        return isset($this->data[$index]) ? htmlspecialchars($this->data[$index]) : null;
    }

    /**
     * @param $label
     * @param $name
     * @return string
     */
    private function getLabel($label, $name){
        return "<label for='" . $name ."'>$label</label>";
    }

    /**
     * @param $label
     * @param $name
     * @return string
     */
    private function getLabelInline($label, $name){
        return "<label for='" . $name ."' class=\"radio-inline\">$label</label>";

    }

    /**
     * @param $html
     * @return string
     */
    private function surround($html){
        return "<div class='form-group'>$html</div>";
    }

    /**
     * @param $label
     * @param $name
     * @param null $placeholder
     * @param null $option
     * @return string
     */
    public function input($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='text' id='".$name."' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='". $placeholder."' ".$option." />
        ");
    }

    /**
     * @param $label
     * @param $name
     * @param null $placeholder
     * @param null $option
     * @return string
     */
    public function password($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='password' id='".$name."' name='" . $name . "' class='form-control' placeholder='". $placeholder."' ".$option." />
        ");
    }

    /**
     * @param $label
     * @param $name
     * @param null $placeholder
     * @param null $option
     * @return string
     */
    public function email($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='email' id='".$name."' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='". $placeholder."' ".$option." />
        ");
    }

    /**
     * @param $label
     * @param $name
     * @param null $placeholder
     * @param null $option
     * @return string
     */
    public function tel($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='tel' id='".$name."' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='". $placeholder."' ".$option." />
        ");
    }

    /**
     * @param $label
     * @param $name
     * @param null $placeholder
     * @param null $option
     * @return string
     */
    public function url($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='url' id='".$name."' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='". $placeholder."' ".$option." />
        ");
    }

    /**
     * @param $label
     * @param $name
     * @param null $placeholder
     * @param null $option
     * @return string
     */
    public function date($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='date' id='".$name."' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='". $placeholder."' ".$option." />
        ");
    }

    /**
     * @param $label
     * @param $name
     * @param null $placeholder
     * @param null $option
     * @return string
     */
    public function number($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='number' id='".$name."' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='". $placeholder."' ".$option." />
        ");
    }

    /**
     * @param $label
     * @param $name
     * @param null $placeholder
     * @param null $option
     * @return string
     */
    public function color($label, $name, $placeholder = null, $option = null){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='color' id='".$name."' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' placeholder='". $placeholder."' ".$option." />
        ");
    }

    /**
     * @param $label
     * @param $name
     * @param $min
     * @param $max
     * @param $step
     * @return string
     */
    public function range($label, $name, $min, $max, $step){
        return $this->surround($this->getLabel($label, $name) . "
        <input type='color' id='".$name."' name='" . $name . "' value='" . $this->getValue($name) ."' class='form-control' max='".$max."' min='".$min."' step='".$step."' />
        ");
    }


    /**
     * @param $label array
     * @param $id array
     * @param $name
     * @param $value array
     * @return string
     */
    public function radio($label, $id, $name, $value){
        $html = "";
        for($i = 0; $i < count($label); $i++){
            $temp = $this->getLabelInline($label[$i], $id[$i])." <input type='radio' name='".$name."' id='".$id[$i]."' value='".$value[$i]."' ";
            if($this->getValue($name) == $value[$i]){
                $temp .= "checked ";
            }
            $temp .= " />";
            $html .= $this->surround($temp);
        }
        return $html;
    }

    /**
     * @param $texte
     * @return string
     */
    public function submit($texte){
        return "<button class='btn btn-primary'>$texte</button>";
    }
}
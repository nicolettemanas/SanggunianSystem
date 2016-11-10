<?php
class ActiveForm extends CActiveForm
{
    public $valuesAsKeys = false;

    public function dropDownList($model,$attribute,$data,$htmlOptions=array())
    {
        if (!$this->valuesAsKeys)
            return parent::dropDownList($model, $attribute, $data, $htmlOptions);

        $newData = array();
        foreach ($data as $value)
            $newData[$value] = $value;
        return parent::dropDownList($model, $attribute, $newData, $htmlOptions);
    }
}
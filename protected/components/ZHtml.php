<?php
class ZHtml extends CHtml
{
    public static function enumDropDownList($model, $attribute, $type, $htmlOptions=array())
    {
		return self::enumItem($model, $attribute, $type, $htmlOptions);
    }
 
    public static function enumItem($model,$attribute,$type) {
        $attr=$attribute;
        self::resolveName($model,$attr);
		$column = $model->tableSchema->columns[$attribute]->dbType;
		
		if($type == "enum_range")
			$sql = "SELECT enum_range(NULL::$column);";
		else if($type == "distinct_select")
			$sql = "SELECT $attribute FROM ".$model->tableName().";";
			
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$enum=$command->queryAll();
		
		if($enum!=null){
			preg_match('/\{(.*)\}/',$enum[0]['enum_range'],$matches);
			foreach(explode(",", $matches[1]) as $value) {
					$value=trim($value, "\"");
					$value=str_replace("'",null,$value);
					$values[$value]=Yii::t('enumItem',$value);
			}
			return $values;
		}
		else
			return null;
    } 
	
	public static function modifiedList($model, $sql, $d_name, $value){
		
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$enum=$command->queryAll();
		
		if($enum!=null){
			foreach($enum as $v) {
				$v=str_replace("'",null,$v);
				
				$values[$v[$value]]=$v[$d_name];
			}
			return $values;
		}
		else
			return null;
	}
}
?>
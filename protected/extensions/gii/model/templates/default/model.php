<?php
# ver: 1.0.1.1

/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>

//******************************************************************************
class <?php echo $modelClass; ?> extends <?php echo $this->baseClass."\n"; ?>
//******************************************************************************
{
	public $request; // Поисковый запрос

	//****************************************************************************
	// AR - методы
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function attributeLabels()
	//----------------------------------------------------------------------------  
	{
		return array(
<?php foreach($labels as $name=>$label): ?>
			<?php echo "'$name' => '$label',\n"; ?>
<?php endforeach; ?>
		);
	}

	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------	
	{
		return array(
	<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
	<?php endforeach; ?>

				// Внимание: удалите лишние атрибуты!
				array('<?php echo implode(', ', array_keys($columns) + array('request' => 'request')); ?>', 'safe', 'on'=>'search'),
		);
	}

	//----------------------------------------------------------------------------
	public function relations()
	//----------------------------------------------------------------------------
	{
		// ВНИМАНИЕ: уточните имя связи
		return array(
<?php foreach($relations as $name=>$relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
		);
	}

	//****************************************************************************
	// Пользовательские методы
	//****************************************************************************


	//****************************************************************************
	// Поиск
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function search()
	//----------------------------------------------------------------------------
	{
		// Внимание: удалите лишние атрибуты!

		$objCriteria = new CDbCriteria;

		// Фильтрация полей
<?php
foreach($columns as $name=>$column)
{
	if($column->type==='string')
	{
		echo "\t\t\$objCriteria->compare('$name', \$this->$name, true);\n";
	}
	else
	{
		echo "\t\t\$objCriteria->compare('$name', \$this->$name);\n";
	}
}
?>

		// Запрос по строке
<?php
foreach($columns as $name=>$column)
{
	if($column->type==='string')
	{
		echo "\t\t\$objCriteria->compare('$name', \$this->request, false, 'OR');\n";
	}
	else
	{
		echo "\t\t\$objCriteria->compare('$name', \$this->request, false, 'OR');\n";
	}
}
?>


		return new CActiveDataProvider($this, array(
			'criteria' => $objCriteria,
		));
	}


	public static function model($className=__CLASS__) {return parent::model($className);}
	public function tableName() {return '<?php echo $tableName; ?>';}
}
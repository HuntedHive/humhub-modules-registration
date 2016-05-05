<?php

class ManageRegistration extends HActiveRecord
{
    const TYPE_TEACHER_LEVEL = 0;
    const TYPE_TEACHER_TYPE = 1;
    const TYPE_SUBJECT_AREA = 2;
    const TYPE_TEACHER_INTEREST = 3;
    const TYPE_TEACHER_OTHER = 4;
    
    const DEFAULT_DEFAULT = 0;
    const DEFAULT_ADDED = 1;
    
    public static $default = [
        self::DEFAULT_DEFAULT => 'Default',
        self::DEFAULT_ADDED => 'Added',
    ];
    
    public static $type = [
        self::TYPE_TEACHER_LEVEL => 'teacher_level',
        self::TYPE_TEACHER_TYPE => 'teacher_type',
        self::TYPE_SUBJECT_AREA => 'subject_area',
        self::TYPE_TEACHER_INTEREST => 'teacher_interest',
        self::TYPE_TEACHER_OTHER => 'teacher_other',
    ];
    
    public $teacher_level;
    public $teacher_type;
    public $subject_area;
    public $teacher_interest;
    public $teacher_other;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ModuleEnabled the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'manage_registration';
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(['name', 'type', 'default'], 'required'),
            array('name', 'length', 'max' => 100),
            ['name','uniqueMethod'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(array('module_id','sort_at','depend'), 'safe'),
        );
    }

    public function uniqueMethod()
    {
        $data = $this->model()->findAll('type='.$this->type . ' AND name="'.$this->name .'"');
        if (!empty($data)) {
            $this->addError("name", "Item name must be unique");
        }
        
        return true;
    }
    
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            //'module_id' => 'Module',
        );
    }

    public static function getTeachetTypeDropDownList()
    {
        return CHtml::listData(self::model()->findAll('type=' .self::TYPE_TEACHER_TYPE), 'id', 'name');
    }

    public static function getDependNames($name) {
        if(empty($name)) {
            return "None";
        }
        
        $otherOption = (!HSetting::model()->find("value='" . ManageRegistration::$type[ManageRegistration::TYPE_SUBJECT_AREA] . "' AND name='type_manage'")->value_text)?' AND t.default='.ManageRegistration::DEFAULT_ADDED:"";
        return self::toDependNames(self::model()->findAll('name="'. $name . '"' . $otherOption));
    }

    protected static function toDependNames($dependArray)
    {
        $html = '';
        foreach ($dependArray as $item) {
            $html.= '<span class="label label-success">';
            if(!empty($item->depend)) {
                $html .= self::model()->find("id=" . $item->depend)->name;
            } else {
                //$html .= "None";
            }
            $html.= '</span>';
        }

        if(empty($html)) {
            $html.= '<span class="label label-success">None</span>';
        }

        return $html;
    }
}

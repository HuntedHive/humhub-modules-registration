<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.org/licences GNU AGPL v3
 *
 */

class ManageRegistration extends HActiveRecord
{
    const TYPE_TEACHER_LEVEL = 0;
    const TYPE_TEACHER_TYPE = 1;
    const TYPE_SUBJECT_AREA = 2;
    const TYPE_TEACHER_INTEREST = 3;
    const TYPE_TEACHER_OTHER = 4;
    const TYPE_SUBJECT_AREA_OTHER = 5;
    
    const DEFAULT_DEFAULT = 0;
    const DEFAULT_ADDED = 1;

    const VAR_OTHER = 'other';

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
        self::TYPE_SUBJECT_AREA_OTHER => 'subject_area_other',
    ];
    
    public $teacher_level;
    public $teacher_type;
    public $subject_area;
    public $teacher_interest;
    public $teacher_other;

    public $file;
    public $apstsfile;
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
            ['file_name', 'unique'],
            array(['name'], 'length', 'max' => 100),
            array('file_name', 'length', 'max' => 255),
            array(['file_path'], 'length', 'max' => 255),
            array('file', 'file', 'types'=>'xlsx, ods'),
            array('apstsfile', 'file', 'types'=> 'xlsx, ods', 'allowEmpty'=>true),
            ['name','uniqueMethod'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(array('module_id','sort_at','depend', 'file_name', 'file_path'), 'safe'),
        );
    }

    public function uniqueMethod()
    {
        $data = $this->model()->findAll('type='.$this->type . ' AND name="'.trim($this->name) .'"');
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

    public static function getDependNames($name, $type) {
        if(empty($name)) {
            return "None";
        }
        
        $otherOption = (!HSetting::model()->find("value='" . ManageRegistration::$type[ManageRegistration::TYPE_SUBJECT_AREA] . "' AND name='type_manage'")->value_text) ? ' AND t.default=' . ManageRegistration::DEFAULT_ADDED : "";
        return self::toDependNames(self::model()->findAll('name="' . $name . '"' . $otherOption), $type);
    }


    protected static function toDependNames($dependArray, $type)
    {
        $html = '';
        foreach ($dependArray as $item) {

            if(!empty($item->depend)) {
                $depend = self::model()->find("id=" . $item->depend);
                if(!empty($depend)) {
                    $html.= '<span class="label label-success">';
                        $html .= $depend->name;
                        $html .= "<i class='subject_close fa fa-times' data-id='$item->id' data-depend='$item->depend'></i>";
                    $html.= '</span>';
                }
            }
        }

        if(empty($html)) {
            $html.= '<span class="label label-success">None</span>';
        }

        return $html;
    }
}

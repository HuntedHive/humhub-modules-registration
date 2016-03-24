<?php
/**
 * HumHub
 * Copyright © 2014 The HumHub Project
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 */

/**
 * This is the model class for table "module_enabled".
 *
 * The table holds all enabled application modules.
 *
 * The followings are the available columns in table 'module_enabled':
 * @property string $module_id
 *
 * @package humhub.models
 * @since 0.5
 */

class ManageRegistration extends HActiveRecord
{
    const TYPE_TEACHER_LEVEL = 0;
    const TYPE_TEACHER_TYPE = 1;
    const TYPE_SUBJECT_AREA = 2;
    const TYPE_TEACHER_INTEREST = 3;
    
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
    ];
    
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
            array(array('module_id','sort_at'), 'safe'),
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
}

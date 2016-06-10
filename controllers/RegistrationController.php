<?php

/**
 * @package humhub.modules_core.admin.controllers
 * @since 0.5
 */
class RegistrationController extends Controller
{
    public $subLayout = "application.modules_core.admin.views._layout";

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array (
            'accessControl', // perform access control for CRUD operations
        );
    }
    
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'expression' => 'Yii::app()->user->isAdmin()'
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $model  = [];
        $keys = array_keys(ManageRegistration::$type);
        $setting = [];
            foreach ($keys as $key) {
            $model[$key] = new ManageRegistration;
        }

        foreach(ManageRegistration::$type as $key => $value) {
            $setting[$key] = HSetting::model()->find('value="' . $value . '"' . " AND name='type_manage'");
        }

        if (\Yii::app()->request->isPostRequest && !empty($_POST['ManageRegistration'])) {
            if($_POST['ManageRegistration']['type'] == ManageRegistration::TYPE_SUBJECT_AREA) {
                if(!empty($_POST['ManageRegistration']['subjectarea']) && is_array($_POST['ManageRegistration']['subjectarea']) && !empty($_POST['ManageRegistration']['name'])) {
                    foreach ($_POST['ManageRegistration']['subjectarea'] as $select) {
                        if($select == "other") {
                            $m_reg1 = new ManageRegistration;
                            $m_reg1->name = $select;
                            $m_reg1->default = ManageRegistration::DEFAULT_ADDED;
                            $m_reg1->type = ManageRegistration::TYPE_SUBJECT_AREA;
                            $m_reg1->depend = 0;
                            $m_reg1->save(false);

                            $m_reg = new ManageRegistration;
                            $m_reg->attributes = $_POST['ManageRegistration'];
                            $m_reg->default = ManageRegistration::DEFAULT_ADDED;
                            $m_reg->type = ManageRegistration::TYPE_SUBJECT_AREA;
                            $m_reg->depend = $m_reg1->getPrimaryKey();
                            $m_reg->save(false);
                        } else {
                            $searchTeacherType = ManageRegistration::model()->find('name="' . $select . '" AND type=' . ManageRegistration::TYPE_TEACHER_TYPE);
                            if (!empty($searchTeacherType) && empty(ManageRegistration::model()->find('name="' . $_POST['ManageRegistration']['name'] . '"AND depend=' . $searchTeacherType->id . ' AND type=' . ManageRegistration::TYPE_SUBJECT_AREA))) {
                                $m_reg = new ManageRegistration;
                                $m_reg->attributes = $_POST['ManageRegistration'];
                                $m_reg->default = ManageRegistration::DEFAULT_ADDED;
                                $m_reg->type = ManageRegistration::TYPE_SUBJECT_AREA;
                                $m_reg->depend = $searchTeacherType->id;
                                $m_reg->save(false);
                            }
                        }
                    }
                    return $this->redirect(Yii::app()->createUrl("/registration/registration/index"));
                } else {
                    if(empty($_POST['ManageRegistration']['name'])) {
                        $model[$_POST['ManageRegistration']['type']]->addError("name", "Enter name");
                    }

                    if(empty($_POST['ManageRegistration']['subjectarea'])) {
                        $model[$_POST['ManageRegistration']['type']]->addError("name", "Empty select data");
                    }
                }

            } else {
                if(strtolower($_POST['ManageRegistration']['name']) != "other") {
                    $path = Yii::getPathOfAlias("webroot") . "/uploads/file/";

                    $model[$_POST['ManageRegistration']['type']]->file = CUploadedFile::getInstance($model[$_POST['ManageRegistration']['type']],'file');
                    $_POST['ManageRegistration']["file_name"] = $model[$_POST['ManageRegistration']['type']]->file->name;
                    $model[$_POST['ManageRegistration']['type']]->file->saveAs($path.$model[$_POST['ManageRegistration']['type']]->file->name);
                    $_POST['ManageRegistration']["file_path"] = $path;

                    $model[$_POST['ManageRegistration']['type']]->attributes = $_POST['ManageRegistration'];
                    $model[$_POST['ManageRegistration']['type']]->save();
                    if (!$model[$_POST['ManageRegistration']['type']]->hasErrors()) {
                        return $this->redirect(Yii::app()->createUrl("/registration/registration/index"));
                    }
                } else {
                    $model[$_POST['ManageRegistration']['type']]->addError("name", "Not valid data");
                }
            }


        }

        $criteria = new CDbCriteria;
        $criteria->condition = 'type = ' . ManageRegistration::TYPE_SUBJECT_AREA . (!$setting[ManageRegistration::TYPE_SUBJECT_AREA]->value_text?' AND `default`='. ManageRegistration::DEFAULT_ADDED:"") . " GROUP BY name ORDER BY updated_at DESC";

        $levels = ManageRegistration::model()->findAll('type = ' . ManageRegistration::TYPE_TEACHER_LEVEL . (!($setting[ManageRegistration::TYPE_TEACHER_LEVEL]->value_text)?' AND `default`='. ManageRegistration::DEFAULT_ADDED:"") . " ORDER BY updated_at DESC");
        $types = ManageRegistration::model()->findAll('type = ' . ManageRegistration::TYPE_TEACHER_TYPE . (!$setting[ManageRegistration::TYPE_TEACHER_TYPE]->value_text?' AND `default`='. ManageRegistration::DEFAULT_ADDED:"") . " ORDER BY updated_at DESC");
        $subjects = ManageRegistration::model()->findAll($criteria);
        $interests = ManageRegistration::model()->findAll('type = ' . ManageRegistration::TYPE_TEACHER_INTEREST . (!$setting[ManageRegistration::TYPE_TEACHER_INTEREST]->value_text?' AND `default`='. ManageRegistration::DEFAULT_ADDED:"") . " ORDER BY updated_at DESC");
        $others = ManageRegistration::model()->findAll('type = ' . ManageRegistration::TYPE_TEACHER_OTHER . (!$setting[ManageRegistration::TYPE_TEACHER_OTHER]->value_text?' AND `default`='. ManageRegistration::DEFAULT_ADDED:"") . " ORDER BY updated_at DESC");

        $this->render('index', [
            'levels' => $levels,
            'types' => $types,
            'subjects' => $subjects,
            'interests' => $interests,
            'others' => $others,
            'model' => $model,
            'setting' => $setting,
        ]);
    }

    public function actionType($type)
    {
        $model = HSetting::model()->find('name="type_manage" AND value="'.ManageRegistration::$type[$type]. '"');
        HSetting::model()->updateAll(['value_text' => !$model->value_text?1:0], 'name = "type_manage" AND value="'.ManageRegistration::$type[$type]. '"');
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionRequired($required)
    {
        $model = HSetting::model()->find('name="required_manage" AND value="'.ManageRegistration::$type[$required]. '"');
        HSetting::model()->updateAll(['value_text' => !$model->value_text?1:0], 'name = "required_manage" AND value="'.ManageRegistration::$type[$required]. '"');
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function actionEdit()
    {
        if (isset($_POST['pk']) && isset($_POST['value'])) {
            $pk = $_POST['pk'];
            $value = $_POST['value'];

            ManageRegistration::model()->updateAll(['name' => $value], 'id=' . $pk);
        } else {
            echo "Erorr of data editing";
        }
    }

    public function actionEditSubject()
    {
        if (isset($_POST['value'])) {
            $value = $_POST['value'];
            $lastValue = $_POST['name'];
            ManageRegistration::model()->updateAll(['name' => $value], ' type='. ManageRegistration::TYPE_SUBJECT_AREA. ' AND name="' .$lastValue. '"');
        } else {
            echo "Erorr of data editing";
        }
    }
    
    public function actionDelete($id)
    {
        ManageRegistration::model()->deleteByPk($id);
        ManageRegistration::model()->deleteAll('depend='. $id);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionDeleteSubject($name)
    {
//        $selectSubject = CHtml::listData(ManageRegistration::model()->findAll('name="'. $name . '" AND type='. ManageRegistration::TYPE_SUBJECT_AREA), "depend", "depend");
        ManageRegistration::model()->deleteAll("name='". $name."' AND type=". ManageRegistration::TYPE_SUBJECT_AREA);
//        ManageRegistration::model()->deleteAll("id IN(". implode(",", $selectSubject) .") AND type=". ManageRegistration::TYPE_TEACHER_OTHER);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function actionSort()
    {
        if (isset($_POST['data']) && isset($_POST['type'])) {
            $i=0;
            foreach ($_POST['data'] as $item_id) {
                $i--;
                $criteria = new CDbCriteria;
                $criteria->addCondition('type='. $_POST['type']);
                $criteria->addCondition('id='. $item_id);
                ManageRegistration::model()->updateAll(array('updated_at' => time() + $i), $criteria);
            }
        } else {
            echo "Erorr of data sorting";
        }
    }
    
    public function actionDeleteSubjectItem()
    {
        if(isset($_POST['dataId']) && isset($_POST['dataDepend'])) {
            ManageRegistration::model()->deleteByPk([
                'id' => $_POST['dataId'],
            ]);
            echo true;
        }

        echo false;
    }
}

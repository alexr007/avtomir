<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 08.02.2017
 * Time: 22:56
 */
class PriceController extends AdminController {

    public function actionIndex()
    {
        $class = 'FileTxt'; // какого типа файлы загружаем
        $file = new $class;

        if(isset($_POST[$class]))
            if (($image = CUploadedFile::getInstance($file,'image')) !=null) {
                $file->image = $image;
                if ($file->uploadFile()) {
                    (new UploadPriceToDb($file->getFullFilePath()))->upload();
                    $this->redirect(['index']);
                }
                else {
                    VarDumper::dump($file->getErrors());
                    $file = new $class;
                }
            }

        $this->render('index',[
            'model'=>$file,
        ]);
    }

}
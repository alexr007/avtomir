<?php

class DbController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionGrabSource()
	{
		$model=new MGrab();
		$model->move();
		
		$this->render('grabSource');
	}
	
	public function actionRelinkCagents() 
	{
		$model=new RelinkCagents();
		$model->run();
		
		$this->render('relinkCagents');
	}
}
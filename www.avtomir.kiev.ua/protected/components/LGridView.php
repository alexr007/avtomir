<?php
class LGridView extends CGridView
{
	public function run()
        {
                $this->registerClientScript();

                echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";

                $this->renderContent();
                //do not use this... $this->renderKeys();

                echo CHtml::closeTag($this->tagName);
        }

} 
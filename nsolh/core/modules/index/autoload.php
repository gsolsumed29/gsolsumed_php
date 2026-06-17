<?php
function  my_autoloader($modelname){
	if(Model::exists($modelname)){
		include Model::getFullPath($modelname);
	}
}
spl_autoload_register('my_autoloader');
?>
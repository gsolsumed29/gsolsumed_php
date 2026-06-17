<?php
if(!isset($_GET["action"])){
	Module::loadLayout();
}else{
	Action::load($_GET["action"],new Request());
}
?>
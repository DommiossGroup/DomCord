<?php 

$_Config_ = new Read('../config/config.yml');
$_Config_ = $_Config_->GetTableau();

$_database_ = new Read('../config/database.yml');
$_database_ = $_database_->GetTableau();

$_State_ = new Read('./state.yml');
$_State_ = $_State_->GetTableau();
$state = $_State_['state'];

<?php
 use Phalcon\Exception as Ex; class ServersCache extends BaseType { public $townFrom; public $state; public $townName; public $stateName; public $townLName; public $stateLName; public $officeSamoDB; public $officeSamoAlias; public $officeCatalogAlias; public $officeCatalogDB; public $onlineIP; public $onlineAlias; public $onlineSamoDB; public $onlineCatalogDB; public $stateFrom; public $stateFromName; public $stateFromLName; public $redirect; public $default; public function transform() { $stateFrom = (defined('STATEFROM')) ? STATEFROM : null; $stateFrom = ($stateFrom === null || ($stateFrom == $this->stateFrom)); if ($this->townName != null && $this->stateName != null && $stateFrom) { $catalogDB = (OFFICE_SQLSERVER == '' && $this->officeSamoAlias == $this->officeCatalogAlias); $samoAlias = ($this->officeSamoAlias == $this->onlineAlias); $this->redirect = false; $this->officeCatalogAlias = $catalogDB ? '' : $this->officeCatalogAlias; $this->officeSamoAlias = $samoAlias ? '' : $this->officeSamoAlias; Core::replaceDbIp($this->onlineIP, hostname); $this->default = false; } else { return false; } } } 
<?php
/* Copyright (C) 2003      Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2012 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@capnetworks.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\defgroup   mymodule     Module MyModule
 *  \brief      Example of a module descriptor.
 *				Such a file must be copied into htdocs/mymodule/core/modules directory.
 *  \file       htdocs/mymodule/core/modules/modMyModule.class.php
 *  \ingroup    mymodule
 *  \brief      Description and activation file for module MyModule
 */
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';


/**
 *  Description and activation class for module MyModule
 */
class modIncoterm extends DolibarrModules
{
	/**
	 *   Constructor. Define names, constants, directories, boxes, permissions
	 *
	 *   @param      DoliDB		$db      Database handler
	 */
	function __construct($db)
	{
        global $langs,$conf;

        $this->db = $db;

		// Id for module (must be unique).
		// Use here a free id (See in Home -> System information -> Dolibarr for list of used modules id).
		$this->numero = 62000;
		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'incoterm';

		// Family can be 'crm','financial','hr','projects','products','ecm','technic','other'
		$this->family = "srm";
		$this->name = preg_replace('/^mod/i','',get_class($this));
		$this->description = "Incoterm management";
		$this->version = 'dolibarr';
		// Key used in llx_const table to save module status enabled/disabled (where MYMODULE is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Where to store the module in setup page (0=common,1=interface,2=others,3=very specific)
		$this->special = 0;
		$this->picto='generic';

		$this->module_parts = array();
		$this->dirs = array();

		$this->config_page_url = array();

		// Dependencies
		$this->depends = array();		// List of modules id that must be enabled if this module is enabled
		$this->requiredby = array();	// List of modules id to disable if this one is disabled
		$this->phpmin = array(5,0);					// Minimum version of PHP required by module
		$this->need_dolibarr_version = array(3,0);	// Minimum version of Dolibarr required by module
		$this->langfiles = array("incoterm");

		$this->const = array(
			array('INCOTERM_ACTIVATE', 'chaine', 0, 'Description de INCOTERM_ACTIVATE')
		);

        $this->tabs = array();

        // Dictionaries
		if (! isset($conf->incoterm->enabled))
        {
        	$conf->incoterm=new stdClass();
        	$conf->incoterm->enabled=0;
        }
		$this->dictionaries=array(
			'langs'=>'incoterm',
            'tabname'=>array(MAIN_DB_PREFIX."c_incoterms"),		// List of tables we want to see into dictonnary editor
            'tablib'=>array("Incoterms"),													// Label of tables
            'tabsql'=>array('SELECT rowid, code, libelle, active FROM '.MAIN_DB_PREFIX.'c_incoterms'),	// Request to select fields
            'tabsqlsort'=>array("rowid ASC"),															// Sort order
            'tabfield'=>array("code,libelle"),															// List of fields (result of select to show dictionary)
            'tabfieldvalue'=>array("code,libelle"),														// List of fields (list of fields to edit a record)
            'tabfieldinsert'=>array("code,libelle"),													// List of fields (list of fields for insert)
            'tabrowid'=>array("rowid"),																	// Name of columns with primary key (try to always name it 'rowid')
            'tabcond'=>array($conf->incoterm->enabled)
		);

        $this->boxes = array();			// List of boxes
		$r=0;

		// Permissions
		$this->rights = array();		// Permission array used by this module
		$r=0;

		// Main menu entries
		$this->menus = array();			// List of menus to add
		$r=0;
	}
}
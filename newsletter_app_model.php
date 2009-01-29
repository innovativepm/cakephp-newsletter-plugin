<?php
/**
* Copyright (c) 2009, Fabio Kreusch
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
* @copyright            Copyright (c) 2009, Fabio Kreusch
* @link                 fabio.kreusch.com.br
* @license              http://www.opensource.org/licenses/mit-license.php The MIT License
*/
class NewsletterAppModel extends AppModel {

    function escape($string) {
		  return "'$string'";
		}

		/**
		* Reimplementation to ignore existing values
		* @return
		* @access
		**/
		function insertMulti($fields, $values, $table=null) {
		  if(!$table) {$table = $this->useTable;}

		  $db =& ConnectionManager::getDataSource($this->useDbConfig);
      $table = $db->fullTableName($table);
      if (is_array($fields)) {
          $fields = join(', ', array_map(array(&$db, 'name'), $fields));
      }
      
      foreach ($values as $key => $line) {
        $values[$key] = '('.join(', ', array_map(array(&$this, 'escape'), $line)).')';
		  }
		  
      $sql_values = join(', ', $values); 
      $this->query("INSERT IGNORE INTO {$table} ({$fields}) VALUES {$sql_values};");		      
     }
}
?>

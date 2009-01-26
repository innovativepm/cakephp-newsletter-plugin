<?php
class NewsletterAppModel extends AppModel {

    function escape($string) {
		  return "'$string'";
		}
		
		#Reimplementation to ignore existing values
		function insertMulti($table, $fields, $values) {
		  $db =& ConnectionManager::getDataSource($this->useDbConfig);
      $table = $db->fullTableName($table);
      if (is_array($fields)) {
          $fields = join(', ', array_map(array(&$db, 'name'), $fields));
      }
      
      foreach ($values as $key => $line) {
        $values[$key] = '('.join(', ', array_map(array(&$this, 'escape'), $line)).')';
		  }
		  
      $count = count($values);
      for ($x = 0; $x < $count; $x++) {
          $this->query("INSERT IGNORE INTO {$table} ({$fields}) VALUES {$values[$x]}");
      }
     }
}
?>

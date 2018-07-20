<?php
 class Samo_Database_Pdo_Dblib implements Samo_Database_Adapter { private $pdo = null; private $charset = null; private $last_message = null; public function __construct() { if (!extension_loaded('pdo_dblib')) { throw new Samo_Exception('Extension "pdo_dblib" not loaded.'); } } public function __destruct() { if ($this->is_connected()) { $this->disconnect(); } } public function client_charset($charset = null) { if (null !== $charset) { if ($this->is_connected() && $charset !== $this->charset) { $this->disconnect(); } $this->charset = $charset; } return $this->charset; } public function connect($params) { $charset = $this->client_charset($params['charset']); $hostname = str_replace(',', ':', $params['hostname']); $tdsver = (isset($params['tdsversion'])) ? $params['tdsversion'] : (($env = getenv('TDSVER')) ? $env : '8.0'); $dsn = sprintf( "dblib:host=%s;dbname=%s;charset=%s;appname=SamoTourOnline;version=%s", $hostname, $params['database'], $charset, $tdsver ); $options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_STRINGIFY_FETCHES => false, ]; if (version_compare(PHP_VERSION, '7.0.6') >= 0) { $options[PDO::ATTR_TIMEOUT] = $params['timeout']; } try { $pdo = new PDO($dsn, $params['username'], $params['password'], $options); } catch (PDOException $e) { $this->last_message = $e->getMessage(); return false; } $this->pdo = $pdo; return $this->pdo; } public function query($sql) { $return = false; $query = false; try { if ($query = $this->pdo->query($sql)) { $dates = ['datetime', 'smalldatetime']; $floats = ['money', 'float', 'decimal']; $integers = ['int', 'tinyint', 'bit']; $resultsets = []; do { $columnCount = $query->columnCount(); if ($columnCount > 0) { $resultset = $query->fetchAll(PDO::FETCH_ASSOC); if (!empty($resultset)) { $columns = [ 'integers' => [], 'dates' => [], 'floats' => [], ]; for ($column = 0; $column < $columnCount; $column++) { $meta = $query->getColumnMeta($column); if (in_array($meta['native_type'], $dates)) { $columns['dates'][] = $meta['name']; } if (in_array($meta['native_type'], $floats)) { $columns['floats'][] = $meta['name']; } if (in_array($meta['native_type'], $integers)) { $columns['integers'][] = $meta['name']; } } foreach ($resultset as &$row) { foreach ($row as $name => &$value) { if (in_array($name, $columns['integers'])) { $value = (null === $value) ? null : intval($value); } if (in_array($name, $columns['floats'])) { $value = (null === $value) ? null : floatval($value); } if (in_array($name, $columns['dates'])) { $value = (null === $value) ? Samo_Datetime::null() : Samo_Datetime::parse($value); } } } } else { $resultset = false; } $resultsets[] = $resultset; } else { $errorInfo = $query->errorInfo(); if ($errorInfo[1] > 0) { throw new PDOException($errorInfo[2], $errorInfo[1]); } } } while ($query->nextRowset()); $return = new Samo_Database_Resultset($sql, $resultsets); } } catch (PDOException $e) { $this->last_message = $e->getMessage(); $return = false; } if ($query instanceof PDOStatement) { $query->closeCursor(); $query = null; } return $return; } public function fetch_assoc($rsql) { $return = $rsql->fetchRow(); return (null === $return) ? false : $return; } public function disconnect() { $this->pdo = null; return true; } public function num_rows($rsql) { return $rsql->rowCount(); } public function num_fields($rsql) { return $rsql->numFields(); } public function next_result($rsql) { if (false === $rsql->nextRowset()) { unset($rsql); return false; } return true; } public function last_message() { $return = ''; if (!empty($this->last_message)) { $return = $this->last_message; $this->last_message = null; } elseif (null !== $this->pdo) { if ($info = $this->pdo->errorInfo()) { $return = $info[2]; } } return $return; } public function free_result($result) { if ($result instanceof PDOStatement) { $result->closeCursor(); } $result = null; return true; } public function fetch_field($result, $offset = -1) { return $result->fetchField($offset); } public function is_connected() { return (null !== $this->pdo); } public function is_resource($param) { return $param instanceof Samo_Database_Resultset; } } 
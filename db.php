<?php
class DB{
  static $db = null;
  static function getDB() {
    if (!self::$db) self::$db = new PDO("mysql:host=localhost;dbname=sns;charset=utf8mb4;","root","", [19 => 5, 3 => 2]);
    return self::$db;
  }

  static function exec($query) {
    try {
      self::getDB()->exec($query);
      return true;
    } catch (Exception $e) {
      return false;
    }
  }

  static function fetch($query) {
    $stmt = self::getDB()->query($query);
    return $stmt->fetch();
  }
  
  static function fetchAll($query) {
    $stmt = self::getDB()->query($query);
    return $stmt->fetchAll();
  }
}
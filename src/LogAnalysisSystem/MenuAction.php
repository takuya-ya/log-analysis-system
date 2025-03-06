<?php

namespace LogAnalysisSystem;

use PDO;

interface MenuAction {
  public function executeMenu(DBConnector $pdo): array;
}

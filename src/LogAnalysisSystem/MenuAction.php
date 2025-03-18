<?php

namespace LogAnalysisSystem;

use PDO;

interface MenuAction {
  public function executeMenu(PDO $pdo): void;
}

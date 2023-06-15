<?php

namespace Drupal\custom_drush\Commands;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Drush\Commands\DrushCommands;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;

class DrushHelpersCommands extends DrushCommands {

  /**
   * @var Drupal\Core\Entity\EntityTypeManagerInterface $entityManager
   *    Entity manager service.
   */

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityManager = $entityTypeManager;
    parent::__construct();
  }

  /**
   * Command that returns a list of all node IDs and titles.
   *
   * @field-labels
   *  id: Node ID
   *  title: Node Title
   * @default-fields id,title
   *
   * @usage drush-helpers:node-list
   *   Returns a list of all node IDs and titles.
   *
   * @command drush-helpers:node-list
   * @aliases node-list
   *
   * @return \Consolidation\OutputFormatters\StructuredData\RowsOfFields
   */
  public function nodeList() {
    $nodes = $this->entityManager->getStorage('node')->loadByProperties([ 'type' => 'article']);
    $rows = [];
    $counter = 0;

    foreach ($nodes as $node) {
      $rows[] = [
        'id' => $node->id(),
        'title' => $node->getTitle(),
      ];

      $counter++;
      if ($counter >= 10) {
        break;
      }
    }

    return new RowsOfFields($rows);
  }
}
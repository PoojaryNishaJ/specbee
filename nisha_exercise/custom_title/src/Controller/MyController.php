<?php
namespace Drupal\custom_title\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Session\AccountInterface;

class MyController extends ControllerBase {

  public function nodeTitle(Node $node) {
    if (!empty($node)) {
        $title = $node->getTitle();
        return  [
            '#markup'=>$title,
        ];
      }
      else {
        throw new NotFoundHttpException();
      }
    }

  public function nodeTitlePageTitle(Node $node) {
  $prepend_text = "Node of ";
    return $prepend_text . $node->getTitle();
  }


public function accessNode(AccountInterface $account, $node) {
    $node = Node::load($node);
    $type = $node-> getType();
    if ($type == 'article' || $type === 'page') {
      $result = AccessResult::allowed();
    }
    else {
      $result = AccessResult::forbidden();
    }

    $result->addCacheableDependency($node);

    return $result;
  }

}
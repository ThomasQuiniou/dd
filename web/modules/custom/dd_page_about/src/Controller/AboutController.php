<?php

namespace Drupal\dd_page_about\Controller;

use Drupal\Core\Controller\ControllerBase;

class AboutController extends ControllerBase
{
  public function content(){
    return [
      "#theme" => "dd_page_about_theme_hook",
    ];
  }
}

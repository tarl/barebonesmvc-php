<?php
  /*
   * BareBones is a one-file, no-configuration, MVC framework for PHP5.
   *
   * "A designer knows he has achieved perfection not when there is nothing left
   * to add, but when there is nothing left to take away."
   * (Antoine de Saint-Exupery) 
   * 
   *
   * (CONTROLLER) USAGE:
   *
   * require('barebones.lib.php');                             // 1) require
   * 
   * class DemoController extends AbstractBareBonesController {// 2) extend
   *   function applyInputToModel() {                          // 3) implement
   *     $mto = new BareBonesMTO('barebones.tpl.php');         // 4) instantiate
   *     $mto->setModelValue('message', 'bare bones demo');    // 5) assign
   *     session_start(); $_SESSION['preserved'] = 1;          // 6) preserve
   *     return $mto;                                          // 7) return
   *   }
   * }
   * 
   * DemoController::sendResponse(new DemoController());       // 8) send
   *
   *  
   * (EXAMPLE) TEMPLATE:
   *
   * <?php
   * echo '$mto->setModelValue(\'message\'....' . $model['message'];
   * ?>
   * <br><br>
   * Session preserved?....<?echo $_SESSION['preserved']; ?>
   * <br><br>
   * GLOBALS....
   * <pre>
   * <?php print_r($GLOBALS); ?>
   * </pre>
   *
   *
   * (HTML) OUTPUT:
   *
   * $mto->setModelValue('message'....bare bones demo
   * <br><br>
   * Session preserved?....1
   * <br><br>
   * GLOBALS....
   * <pre>
   * Array
   * (
   * [_SESSION] => Array
   * (
   * [preserved] => 1
   * )
   * </pre> 
   *
   *
   *Copyright (c) 2007, George M. Jempty
   *
   *All rights reserved.
   *Redistribution and use in source and binary forms, with or without
   *modification, are permitted provided that the following conditions are met:
   *  
     * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
     * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
     * Neither the name of the <ORGANIZATION> nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
   *
   *THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
   *"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
   *LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
   *A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
   *CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
   *EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
   *PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
   *PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
   *LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
   *NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
   *SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
   * 
   */  

  interface IBareBonesController {
    function setMto(IModelXfer $mto);
    static function sendResponse(IBareBonesController $controller);
    function applyInputToModel();
  }
  
  abstract class AbstractBareBonesController implements IBareBonesController {
    protected $mto;
    
    function setMto(IModelXfer $mto) {
      $this->mto = $mto;
    }
    
    static function sendResponse(IBareBonesController $controller) {
      $controller->setMto($controller->applyInputToModel());
      $controller->mto->applyModelToView();
    }
  }
  
  interface IModelXfer {
    function setView($view);
    function setModel($model);
    function setModelValue($key, $value);
    function applyModelToView();
  }

  abstract class AbstractMTO implements IModelXfer {
    protected $view;
    protected $model;
    
    function setView($view) {
      $this->view = $view;    
    }
    
    function setModel($model) {
      $this->model = $model;
    }
    
    function setModelValue($key, $value) {
      $this->model[$key] = $value;
    }
    
    protected function preserveSession() {
      $session = $GLOBALS['_SESSION'];
      unset($GLOBALS);
      $GLOBALS['_SESSION'] = $session;      
    }
  }
  
  class BareBonesMto extends AbstractMTO {    
    function __construct($view) {
      $this->setView($view);
    }
    
    function applyModelToView() {
      $this->preserveSession();
      $model = $this->model;
      include($this->view);
    }    
  }
?>
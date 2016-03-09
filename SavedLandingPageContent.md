Weighing in at just 60 lines of code (excluding comments), the BareBones MVC framework for PHP5 is perfect for:
  * small-to-medium websites; in other words, the vast majority, i.e. shared hosting sites without htaccess and/or mod\_rewrite capabilities
  * as a foundation for PHP software such as CMS, weblog and/or wiki software
  * as a foundation for a "full stack" framework; e.g with (request) dispatching <sub>1</sub>, object-relational mapping (ORM) <sub>2</sub>, etcetera (see footnotes at bottom)

BareBones' sole goal is proper separation of concerns between the Model, View and Controller layers; this is achieved through just two abstractions, the controller itself and a "ModelTransferObject" (MTO), and is exemplified through the source for the following "template method":

```
    static function sendResponse(IBareBonesController $controller) {
      $controller->setMto($controller->applyInputToModel());
      $controller->mto->applyModelToView();
    }
```

Using BareBones can be succinctly summarized as requiring just 2 steps:
  1. implementing applyInputToModel()
  1. calling sendResponse()

Or, in more detail, from the source comments:
```
   * require('barebones.lib.php');                             // 1) require
   * 
   * class DemoController extends AbstractBareBonesController {// 2) extend
   *   function applyInputToModel() {                          // 3) implement
   *     $mto = new BareBonesMTO('barebones.tpl.php');         // 4) instantiate
   *     $mto->setModelValue('message', 'bare bones demo');    // 5) assign
   *     session_start(); $_SESSION['preserved'] = 1;          // 6) preserve (optional)
   *     return $mto;                                          // 7) return
   *   }
   * }
   * 
   * DemoController::sendResponse(new DemoController());       // 8) send
```

_Note that despite being static, because sendResponse() accepts a new object instance, thread safety is maintained through "stack confinement"_

Notes on the inspiration for BareBones, as well as observations on some patterns besides MVC, can be found at http://docs.google.com/Doc?id=dcdwmnq5_22fpsbjr

Direct inquiries to jemptymethod at gmail dot com

"A designer knows he has achieved perfection not when there is nothing left to add, but when there is nothing left to take away."
(Antoine de Saint-Exupery)

  1. ##### Because AbstractBareBonesController::sendResponse() is static, if htaccess and mod\_rewrite functionality is exposed to your website, it is an easy matter to add dispatching, _without_ relying on reflection. #####
  1. ##### By not coupling itself to a specific ORM implementation, BareBones' avoids bloat that would be unnecessary should database access not be necessary, and might even encourage a more orthogonal design and/or best-of-breed approach when ORM is deemed necessary #####
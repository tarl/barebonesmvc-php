## The ModelTransferObject: DTOs for Web/MVC ##

Model Transfer Objects (MTO) are nothing but Data Transfer Objects (DTO) in an MVC context.    DTO's ideally are meant to transfer data over a distribution boundary, and the boundaries between the Model, View and Controller facets of MVC certainly qualify.

DTO's are often referred to as Value Objects (VO) but this gives the mistaken impression that DTO's need only be comprised of object attributes, without behavior.  This is absolutely erroneous, as the one behavior that DTO's should indeed implement can be discerned from its name: a (data) transfer strategy.

The default BareBonesMTO implementation intends an associative array rather than object attributes for its ephemeral data storage needs, so that its transfer strategy is just a matter of exposing this array to the template (set with _setView_) to be included.  BareBones' MTO interface provides both a _setModel_ and a _setModelValue_ method, for setting the entire model (array) at once, and setting the model one value at a time, respectively.

The ModelTransferObject concept was largely inspired by Spring WebMVC's "ModelAndView" abstraction, but with a couple of important distinctions:

  1. ModelTransferObject is a much more meaningful and precise name than ModelAndView
  1. A ModelAndView's transfer strategy is not meant to be modified, unlike BareBones/MTO's  _applyModelToView_ method; a default implementation is provided but this can be overridden

_applyModelToView_ rounds out BareBones' IModelXfer interface; here it is in its entirety straight from the source's mouth:

```
  interface IModelXfer {
    function setView($view);
    function setModel($model);
    function setModelValue($key, $value);
    function applyModelToView();
  }
```



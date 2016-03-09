1000 downloads in less than six months to me demonstrates that developers are looking for simpler ways of doing things.  However to paraphrase Einstein:

> "Everything should be made as simple as possible, but no simpler."

And I think I went _too_ far with barebonesmvc.

Here's how.  In the default "BareBonesMto", I clobber everything in the $GLOBALS array, except for the session, via the call to $this->preserveSession() within applyModelToView().  This was short sighted: it prevents a developer from implementing "sticky forms" that echo a previously entered form value, for instance if other form fields don't validate.

This shortcoming came to mind as I actually successfully [used barebonesmvc](http://pondpath.com/george_jempty_resume.pdf) to convert 70+ HTML pages to PHP in about a month.  If I continue in that project long enough to implement some sticky forms that have been requested, I will either either delete the offending line -- the one calling $this->preserveSession() -- or extend BareBonesMto and re-implement applyModelToView().

At the same time this struck me though, I realized that what is needed is an additional abstraction that is the counter balance to the "ModelTransferObject": a "RequestTransferObject".  Once I populate this with form data, _then_ I can call the preserveSession() method.

Objects such as the envisioned "RequestTransferObject" already exist in other frameworks: Struts' "Form" object springs to mind.  The abstractions I've identified are not new: only their names are.

My new goal moving beyond barebonesmvc is to create an entire family of lightweight MVC frameworks for multiple web platforms (not unlike the xUnit family of testing frameworks).  Indeed, earlier in the summer before releasing barebonesmvc on code.google.com, I'd ported the concepts to mod\_python; furthermore I have experience with ASP, Java and Perl, and am interested in Ruby, Lua, Haskell: you name it.

Stay tuned as I strive to strike the perfect balance between over-simplicity, and framework-itis.
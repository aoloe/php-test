# Test

A tiny test framework.

Basically, it does not do much more than showing the list of succeeding and failing tests. In the latter case, it also displays the expected and actual value.

And it tries to intelligently convert to string value that are not easy to read (false, null, arrays, ...).

Well, it also gives acces to private methods, if you want to test them, too.

You know, it allows you to evidentiate the tests by using `assert`, `start`, and `stop`. For those cases where a little bit of test is better than no tests.

And it has no dependencies. In less than 100 LOC.

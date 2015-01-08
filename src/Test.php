<?php
namespace Aoloe;

/**
 * TODO:
 * - give an option to only show fails + summary
 */
class Test {

    public function __construct(){
        assert_options(ASSERT_ACTIVE, 1);
        assert_options(ASSERT_WARNING, 0);
        assert_options(ASSERT_QUIET_EVAL, 1);
        assert_options(ASSERT_CALLBACK, function($file, $line, $code, $desc) {$this->my_assert_handler($file, $line, $code, $desc);});
        $this->render_css();
    }

    public function start($name = null) {
        echo("<h1>$name</h1>");
    }

    public function stop($name = null) {
        // eventually show the summary
    }

    public function assert_identical($description, $actual, $expected) {
        $result = false;
        if (assert($expected === $actual, $description)) {
            echo "<p class=\"test\"><span class=\"pass\">\"$description\" passed</span></p>\n";
            $result = true;
        } else {
            echo "<p class=\"test\">expected:</p>\n";
            echo "<pre>".$this->value_to_string($expected)."</pre>\n";
            echo "<p class=\"test\">actual value:</p>\n";
            echo "<pre>".$this->value_to_string($actual)."</pre>\n";
        }
        return $result;
    }

    public function assert_true($description, $actual) {
        return $this->assert_identical($description, $actual, true);
    }

    public function assert_false($description, $actual) {
        return $this->assert_identical($description, $actual, false);
    }

    /**
     * allows to test private methods
     * @param args this methos allows a list of parameters that will be used as arguments for the mehod
     */
    public function call_method($obj, $name, $args = null) {
        $args = array_slice(func_get_args(), 2);
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }

    private function my_assert_handler ($file, $line, $code, $desc = null)
    {
        echo "<p class=\"test\"><span class=\"fail\">\"$desc\" failed</span> at $file:$line:$code</p>\n";
        echo "\n";
    }

    private function value_to_string($value) {
        $result = $value;
        if (is_null($value)) {
            $result = '&lt;null&gt;';
        } elseif (is_bool($value)) {
            $result = $value ? '&lt;true&gt;' : '&lt;false&gt;';
        } elseif (is_array($value)) {
            $result = json_encode($value);
        }
        return $result;
    }
    private function render_css() {
        echo <<<EOT
<style>
.test .pass {
    color:green;
}
.test .fail {
    color:red;
}
</style>
EOT;
    }

}

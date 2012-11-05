<?php

//
// Reporter with more details:
// - http://simpletest.org/en/reporter_documentation.html
//
class ReporterShowingPasses extends HtmlReporter {
    
    function paintPass($message) {
        parent::paintPass($message);
        print "<span class=\"pass\">Pass</span>: ";
        $breadcrumb = $this->getTestList();
        array_shift($breadcrumb);
        print implode("->", $breadcrumb);
        print "->$message<br />\n";
    }
    
    protected function getCss() {
        return parent::getCss() . ' .pass { color: green; }';
    }
}

?>
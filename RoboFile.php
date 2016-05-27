<?php

use Robo\Tasks;

class RoboFile extends Tasks {

    function build() {
        $this->taskCopyDir(['src/main' => 'build/classes/'])->run();
    }

    function buildPackage() {
        $this->taskPack("build/csreporter.zip")
                ->add("autoloader.php")
                ->addFile("", "build/classes/")
                ->run();
    }

    function clean() {
        $this->taskCleanDir(["build"])->run();
    }
}

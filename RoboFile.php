<?php

use Robo\Tasks;

class RoboFile extends Tasks {

    function build() {
        $this->taskCopyDir(['src/main' => 'build/classes/'])->run();
    }

    function buildPackage() {
        $this->build();
        
        $this->taskPack("build/csreporter-api.zip")
                ->addFile("", "build/classes/")
                ->run();
    }

    function clean() {
        $this->taskCleanDir(["build"])->run();
    }
}

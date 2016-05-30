<?php

use Robo\Tasks;

class RoboFile extends Tasks {

    function build() {
        $this->taskCopyDir(['src/main' => 'build/classes/'])->run();
    }

    function distPackage() {
        $this->build();

        $this->taskPack("build/csreporter-api.zip")
                ->addFile("", "build/classes/")
                ->run();
    }

    function distDocs() {
        $this->cleanDocs();

        $this->taskApiGen('./vendor/bin/apigen generate')
                ->source("./src/main/")
                ->destination("build/docs/")
                ->run();
    }

    function dist() {
        $this->distPackage();
        $this->distDocs();
    }

    function clean() {
        $this->taskCleanDir(["build"])->run();
    }

    function cleanDocs() {
        if (file_exists("build/docs")) {
            $this->taskCleanDir(["build/docs"])->run();
        }
    }

}

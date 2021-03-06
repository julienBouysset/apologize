<?php
namespace App\Service;


class RenderJS
{

    public function renderJS($components,string $message = null)
    {
        $renderer_source = file_get_contents(__DIR__ . '/../../node_modules/vue-server-renderer/basic.js');
        $app_source = file_get_contents(__DIR__ . '/../../public/build/server-' . $components . '.js');
        $v8 = new \V8Js();
        ob_start();
        $v8->executeString('var process = { env: { VUE_ENV: "server", NODE_ENV: "production" }}; this.global = { process: process };');
        $v8->executeString("var message = '" . $message . "';" );
        $v8->executeString($renderer_source);
        $v8->executeString($app_source);
        return ob_get_clean();
    }
}

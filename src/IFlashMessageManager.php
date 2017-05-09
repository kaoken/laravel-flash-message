<?php
namespace Kaoken\FlashMessage;

interface IFlashMessageManager
{
    public function getInstance();
    public function hasSuccess();
    public function hasInfo();
    public function hasWarnings();
    public function hasError();

    public function successes();
    public function info();
    public function warnings();
    public function errors();

    public function pushSuccess($msg);
    public function pushInfo($msg);
    public function pushWarning($msg);
    public function pushError($msg);
}
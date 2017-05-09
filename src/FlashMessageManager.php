<?php
namespace App\Library\FlashMessage;

class FlashMessageManager implements IFlashMessageManager
{
    /**
     * セッション名
     * @var string
     */
    protected $sessionKey = "kaoken.flash.message.manager";

    /**
     * Application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    protected $aBeforeMsg = [];

    protected $aMsg = [];

    /**
     * @var bool
     */
    protected $isInit = false;

    /**
     * Create a new mail template instance.
     *
     * @param  \Illuminate\Foundation\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Call from the service provider `boot` method.
     * @see FlashMessageServiceProvider::boot
     */
    public function Init(){
        if( !$this->isInit ){
            $t = session($this->sessionKey);
            if(session()->has($this->sessionKey))
                $this->aBeforeMsg = session($this->sessionKey);
            else{
                $this->aBeforeMsg['success'] = [];
                $this->aBeforeMsg['info'] = [];
                $this->aBeforeMsg['warning'] = [];
                $this->aBeforeMsg['error'] = [];
            }
            session()->forget($this->sessionKey);
            $this->aMsg['success'] = [];
            $this->aMsg['info'] = [];
            $this->aMsg['warning'] = [];
            $this->aMsg['error'] = [];
            $this->isInit = true;
        }
    }

    /**
     * Cast to the interface
     * @param IFlashMessageManager $i
     * @return IFlashMessageManager
     */
    private function cast(IFlashMessageManager $i) { return $i; }

    /**
     * Get interface
     * @return IFlashMessageManager
     */
    public function getInstance()
    {
        return $this->cast($this);
    }

    // <editor-fold desc="Does it has?">
    /**
     * Does the message has?
     * @param string $level
     * @return bool
     */
    protected function hasMessage($level)
    {
        $this->Init();
        if( !array_key_exists($level,$this->aBeforeMsg)) return false;
        return count($this->aBeforeMsg[$level])>0;
    }
    /**
     * Does the Success message has?
     * @return bool If so, it returns `true`
     */
    public function hasSuccess()
    {
        return $this->hasMessage('success');
    }
    /**
     * Does the Info message has?
     * @return bool If so, it returns `true`
     */
    public function hasInfo()
    {
        return $this->hasMessage('info');
    }
    /**
     * Does the Warnings message has?
     * @return bool If so, it returns `true`
     */
    public function hasWarnings()
    {
        return $this->hasMessage('warning');
    }
    /**
     * Does the Error message has?
     * @return bool If so, it returns `true`
     */
    public function hasError()
    {
        return $this->hasMessage('error');
    }
    // </editor-fold>


    // <editor-fold desc="Acquire messages for each level.">
    /**
     * For each `$level`, get a message.
     * @param string $level
     * @return mixed
     */
    protected function getMessage($level)
    {
        $this->Init();
        return $this->aBeforeMsg[$level];
    }
    /**
     * Acquire all success messages.
     * @return array
     */
    public function successes()
    {
        return $this->getMessage('success');
    }
    /**
     * Acquire all info messages.
     * @return array
     */
    public function info()
    {
        return $this->getMessage('info');
    }
    /**
     * Acquire all warning messages.
     * @return array
     */
    public function warnings()
    {
        return $this->getMessage('warning');
    }
    /**
     * Acquire all error messages.
     * @return array
     */
    public function errors()
    {
        return $this->getMessage('error');
    }
    // </editor-fold>


    // <editor-fold desc="Push messages">
    /**
     * Push messages
     * @param string $level
     * @param mixed $msg
     */
    protected function pushMessage($level, $msg)
    {
        $this->Init();
        $this->aMsg[$level][] = $msg;
        session()->put($this->sessionKey,$this->aMsg);
    }
    /**
     * Push a success message.
     * @param mixed $msg
     */
    public function pushSuccess($msg)
    {
        $this->pushMessage('success',$msg);
    }
    /**
     * Push a info message.
     * @param mixed $msg
     */
    public function pushInfo($msg)
    {
        $this->pushMessage('info',$msg);
    }
    /**
     * Push a warning message.
     * @param mixed $msg
     */
    public function pushWarning($msg)
    {
        $this->pushMessage('warning',$msg);
    }
    /**
     * Push a error message.
     * @param mixed $msg
     */
    public function pushError($msg)
    {
        $this->pushMessage('error',$msg);
    }
    // </editor-fold>
}
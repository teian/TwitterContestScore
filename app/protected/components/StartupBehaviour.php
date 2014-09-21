<?php
class StartupBehavior extends CBehavior{
    public function attach($owner){
        $owner->attachEventHandler('onBeginRequest', array($this, 'beginRequest'));
    }

    public function beginRequest(CEvent $event){

        // Holy Moly IE fix stuff lol!
        if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        {
            header('X-UA-Compatible: IE=edge,chrome=1');
        }
    }
}
?>
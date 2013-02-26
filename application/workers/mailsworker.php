<?php
 
class MailsWorker
{
    // Resque looks for the "perform" function to "run" the worker, without it the worker won't run
    public function perform()
    {
      if ($this->args['use_to'] == 'confirmation_password'){
        Mailer::send_activation_email($this->args['user_id'], $this->args['url_base']);
      }
      if ($this->args['use_to'] == 'send_forgot_password'){
        Mailer::send_forgot_password($this->args['user_id'], $this->args['url_base']);
      }
    }
 
    public function do_work()
    {
        // You can also call this function
    }
}

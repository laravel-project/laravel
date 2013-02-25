<?php
 
class MailsWorker
{
    // Resque looks for the "perform" function to "run" the worker, without it the worker won't run
    public function perform()
    {
      Mailer::send_activation_email($this->args['user_id']);
      echo 'Ari....';
      $user = User::find($user_id);
      echo $user->name;
    }
 
    public function do_work()
    {
        // You can also call this function
    }
}

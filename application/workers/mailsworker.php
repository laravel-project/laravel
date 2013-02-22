<?php
 
class MailsWorker
{
    // Resque looks for the "perform" function to "run" the worker, without it the worker won't run
    public function perform()
    {
        // All of your code should go here
 
        // You can access your args that you passed from the task via
        //$mail = new SMTP();
        //$mail->to($this->args['email']);
        //$mail->from('developer.laravel@gmail.com', 'Developer');
        //$mail->subject('Hello World');
        //$mail->body('This is a example of activation email 
        //<a href='.URL::to('confirmation_password').'?confirmation_token='
          //.$this->args['confirmation_token'].'&key_id='.$this->args['key_id'].'>
          //click in here to activation your email
      //</a>');
      // 
      echo Date::mysql_format();

    }
 
    public function do_work()
    {
        // You can also call this function
    }
}

<?php

class SendEmail_Task
{
    public function run()
    {
      // You can pass arguments into the worker as payload
      
      $args = array('name' => 'John Smith');
      Resque::enqueue('Laravel', 'MailsWorker', $args);
      echo "Resque job queued.\n";
      return;
    }
}

<?php

namespace services\email_messages;

class SendMessageTemplate
{
    public function creationMessage(string $name, string $email, string $phone)
    {
        $emailBody = '
   <body>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Your have received message from '.$name.'</div><br>
             <div>Email :  '.$email.'</div><br>
             <div>Phone :  '.$phone.'</div><br>
            </body>
            ';
        return $emailBody;
    }

}

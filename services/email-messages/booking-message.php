<?php

namespace services\email_messages;

class SendMessageBookingTemplate
{
    public function creationMessage(string $name, string $email, string $package)
    {
        $emailBody = '
   <body>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">'.$name.' purchased package of '.$package.' </div><br>
             <div>Email of user :  '.$email.'</div><br>
            </body>
            ';
        return $emailBody;
    }

}

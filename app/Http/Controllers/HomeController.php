<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Chat;
use App\ChatParent;
use App\Customer;
use App\User;
use App\UserPackage;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use services\email_messages\JobCreationMessage;
use services\email_messages\SendMessageBookingTemplate;
use services\email_messages\SendMessageTemplate;
use services\email_services\EmailAddress;
use services\email_services\EmailBody;
use services\email_services\EmailMessage;
use services\email_services\EmailSender;
use services\email_services\EmailSubject;
use services\email_services\MailConf;
use services\email_services\PhpMail;
use services\email_services\SendEmailService;
use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDashboard()
    {
//        $thirtyDays = date("Y-m-d", strtotime("+32 days"));
//        $eventsList = Event::where('user_id', Auth::user()->id)->where('start', '<' ,$thirtyDays)->where('start', '>=' ,date("Y-m-d"))->get();
        return view('home');
    }
    public function chat(){
        $chats = ChatParent::all();
        return view('chat')->with(['chats' => $chats]);
    }

    public function chatDetails($id){
        return view('chat-details')->with(['chats' => Chat::where('id_chat', $id)->get(), 'parentId' => $id]);
    }

    public function sendSMS($parentId, Request $request){
        $number = ChatParent::where('id', $parentId)->first()['number'];
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($number,
            ['from' => $twilio_number, 'body' => $request->message] );

        $chat = new Chat();
        if (!empty(Session::get('isAdmin'))){
            $chat->sender = Admin::where('id', Session::get('id'))->first()['email'];
        }
        else {
            $chat->sender = User::where('id', Session::get('userId'))->first()['name'];
        }

        $chat->message = $request->message;
        $chat->id_chat = $parentId;
        $chat->save();
        return redirect()->back();
    }

    public function icomingSms(){
        $response = new MessagingResponse();
        $response->message("The Robots are coming! Head for the hills!");
        $chat = new Chat();
        $chat->sender = 'unknown';
        $chat->message = 'ok';
        $chat->id_chat = '1';
        $chat->save();
        print $response;
    }

    public function history(){

       return view('history')->with(['packages' => UserPackage::where('id_user', Session::get('userId'))->get()]);
    }

    public function sendMail(Request $request){
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $subject = new SendEmailService(new EmailSubject("Hi, You have received message from "."   ". $name . ' through Ashley solutions'));
        $mailTo = new EmailAddress('me.aliriaz007@gmail.com');
        $message = new SendMessageTemplate();
        $emailBody = $message->creationMessage($name, $email, $phone);
        $body = new EmailBody($emailBody);
        $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
        $sendEmail = new EmailSender(new PhpMail(new MailConf("smtp.gmail.com", "admin@dispatch.com", "secret-2020")));
        $result = $sendEmail->send($emailMessage);
    }

    public function savePackage(Request $request){
        $package = new UserPackage();
        $package->package = $request->package;
        $package->status = "payed";
        $package->id_user = Session::get('userId');
        $package->save();
        $user = User::where('id', $package->id_user)->first();
        $package = '';
        if ($request->package == 1){
            $package = ' 5-10 hours ';
        }else{
            $package = ' 40 hours a week for 3 months ';
        }
        $this->sendMailOfBooking($user->name, $user->email, $package);
        return redirect('/history');
    }

    public function sendMailOfBooking(string $name, string $email, string $package){
        $subject = new SendEmailService(new EmailSubject("Hi, ". $name . ' purchased your package from Ashley solutions'));
        $mailTo = new EmailAddress('me.aliriaz007@gmail.com');
        $message = new SendMessageBookingTemplate();
        $emailBody = $message->creationMessage($name, $email, $package);
        $body = new EmailBody($emailBody);
        $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
        $sendEmail = new EmailSender(new PhpMail(new MailConf("smtp.gmail.com", "admin@dispatch.com", "secret-2020")));
        $result = $sendEmail->send($emailMessage);
    }
}

<?php

namespace App\Jobs;

use App\User;
use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class SendReminderEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {

        $this->user = Auth::user()->name;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailer->send('queueemail',['user'=>$this->user],function($m){
            $m->to('371608656@qq.com','史文军')->subject('欢迎注册我们的网站，请激活您的账号！');
        });
    }
}

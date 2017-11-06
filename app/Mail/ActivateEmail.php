<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateEmail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	protected $user;
	public function __construct($user) {
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		$user = $this->user;
		$url = config('app.url') . '/active' . '/' . $user->id . '/' . $user->activate->code;
		return $this->markdown('home-page.emails.activate-email', compact('url', 'user'));
	}
}

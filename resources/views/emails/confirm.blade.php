<h1>Please Confirm Your Email for Bible exchange</h1>

<p>Thanks for registering! Please confirm your email by clicking the link below.</p>

<p>
<a href='{!! URL::to("http://bible.exchange/register/{$confirmation_code}") !!}'>
    {!! URL::to("http://bible.exchange/register/{$confirmation_code}") !!}
</a>
</p>

<p>P.S. <br>
If the link isn't working just copy and paste the address into your browser.
</p>

<img src="" />
<img src="{{ $message->embed(public_path() . '/assets/img/be_logo.png') }}" />
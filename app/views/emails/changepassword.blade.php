Hi {{ $userName }}
<br>
<a href="{{ URL::route('userChangePassword',array('token' => $token)) }}">Click here to change your password</a>
<br><br>
Thanks,
admin.ithands.net
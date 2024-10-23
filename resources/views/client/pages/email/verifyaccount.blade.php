<h3>Chào mừng {{ $account->full_name }} đến với gundam win</h3>
<p>Rất hận hạnh được biết bạn</p>
<a href="{{route('auth.verify-account',$account->email)}}">Bấm đây để xác thực tài khoản của bạn</a>

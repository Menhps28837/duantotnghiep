<div style="border: 3px solid green; padding: 15px; background: lightgreen; width: 600px; margin: auto">
    <h3 style="font-size: 18px">Xin chào {{$customer->name}}</h3>
    <p style="font-size: 18px">
        Để tạo mật khẩu mới mời bạn click vào đường link bên dưới.
    </p>
    <a href="{{route('reset_password', $token)}}" style="display: inline-block; padding: 7px 25px; color:white; background: darkblue;font-size: 18px">Reset Password</a>
</div>
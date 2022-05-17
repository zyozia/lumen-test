<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset password</title>
    <style>
        form {
            text-align: center;
            width: 350px;
            position: absolute;
            left: 35%;
            top: 20%
        }
        .container {
            text-align: center
        }
    </style>

</head>
<body>
    <form>
        <div class="container">
            <input type="hidden" value="{{$token}}" /><br />
            <div>
                <label> Email </label>
                <div>
                    <input type="email" name="email" value="{{$email}}" />
                </div>
            </div>
            <div>
                <label> Password </label><br />
                <div>
                    <input type="password" name="password" id="password" />
                </div>
            </div>
            <div>
                <label> Password confirm </label>
                <div>
                    <input type="password" name="password_confirmation" id="password_confirmation" />
                </div>
            </div>
            <div>
                <button type="button" onclick="resetPassword()">{{__('Change')}}</button>
            </div>
        </div>
    </form>
    <script>
        function resetPassword() {
            let pas = document.getElementById('password').value;
            let confirm =  document.getElementById('password_confirmation').value;
            if(
                pas.length > 0 &&
                confirm.length > 0 &&
                pas.length  === confirm.length
            ) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", '{{ route('api.user.reset-password') }}', true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.send(JSON.stringify({
                    token: '{{$token}}',
                    email: '{{$email}}',
                    password: pas,
                    password_confirmation: pas
                }));
                xhr.onreadystatechange = function() {
                    if(this.readyState == 4) {
                        if(this.status == 200) {
                            alert('Success');
                        } else {
                            alert(this.responseText);
                        }
                    }
                };
            } else {
                alert('Your request is invalid')
            }
        }
    </script>
</body>
</html>


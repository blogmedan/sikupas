@extends('login.applogin')

@section('content')
<h3><i class="fa fa-user"></i> Login Siswa</h3>
    @if(\Session::has('alert'))
      <div class="alert alert-danger">
        <div>{{Session::get('alert')}}</div>
      </div>
    @endif
    @if(\Session::has('alert-success'))
      <div class="alert alert-success">
        <div>{{Session::get('alert-success')}}</div>
      </div>
    @endif
    <form action="{{ url('/loginsiswa') }}" method="post">
    {{ csrf_field() }}
      <div class="form-group has-feedback">
        <input type="username" name="username" class="form-control" placeholder="Username...">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password...">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
      <!-- /.col -->
      <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <a href="#">I forgot my password</a><br>
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!--a href="register.html" class="text-center">Free Register</a-->

  </div>
  <!-- /.login-box-body -->
</div>
@endsection
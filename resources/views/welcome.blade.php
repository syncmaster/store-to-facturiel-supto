    @extends('header')

        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Факториел
                </div>

                <div class="links">
                    <form method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Your Email *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Your Password *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-default" value="Вход в системата" />
                        </div>
                    </form>
                    @if(isset($error))
                    <div class="alert alert-danger alert-dismissible">
                        <button type = "button" class="close" data-dismiss = "alert">x</button>
                        <p class="text-danger">{{$error}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @extends('footer')
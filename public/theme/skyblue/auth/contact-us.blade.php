@extends($theme.'.layouts.app')
@section('content')
<section class="background-maroon heading-section">
    <div class="container">
        <h2 class="heading">Contact Details</h2>
    </div>
</section>
<section class="margin-T-20 min-height-450">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="post">
                    <p class="post__intro">
                        <strong>Company Name:</strong> Genealogy Network Hub<br/>
                        <strong>Email: </strong><a href="mailto:samtg@genealogynetworkhub.com">samtg@genealogynetworkhub.com</a> <br />
                        <strong>Contact No:</strong>+18254936578
                    </p>
                </div>
            </div> <!--col-sm-12 end-->
        </div><!--row end-->
        <div class="row">
            <!--<form>-->
            <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                          @if(Session::has($msg))
                          <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                          @endif
                        @endforeach
					</div>
            <form id="registrationForm" role="form" method="POST" action="{{ url('page/contact-us') }}" >
                {!! csrf_field() !!}
                <div class="col-sm-12">
                    <strong>Please fill below details to contact us or you have any query.</strong>
                </div>
                
                <div class="form-group col-md-3 col-sm-6">
                    <div class="input-group width-100Per">
                        <input type="text" class="form-control" id="ContactFName" name="ContactFName" value={{old('ContactFName')}}>
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="ContactFName">Name</label>
                        @if ($errors->has('ContactFName'))
                            <span class="text-danger">
                                {{ $errors->first('ContactFName') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <div class="input-group width-100Per">
                        <input type="text" class="form-control" id="ContactLName" name="ContactLName" value={{old('ContactLName')}}>
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="ContactLName">Last Name</label>
                        @if ($errors->has('ContactLName'))
                            <span class="text-danger">
                                {{ $errors->first('ContactLName') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <div class="input-group width-100Per">
                        <input type="email" class="form-control" id="ContactEmail" name="ContactEmail" value={{old('ContactEmail')}}>
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="ContactEmail">Email</label>
                        @if ($errors->has('ContactEmail'))
                            <span class="text-danger">
                                {{ $errors->first('ContactEmail') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <div class="input-group width-100Per">
                        <input type="text" class="form-control" id="ContactNo" name="ContactNo" value={{old('ContactNo')}}>
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="ContactNo">Phone Number</label>
                        @if ($errors->has('ContactNo'))
                            <span class="text-danger">
                                {{ $errors->first('ContactNo') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <textarea type="text" class="form-control" id="ContactMsg" name="ContactMsg" value={{old('ContactMsg')}}></textarea>
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="ContactMsg">Message</label>
                        @if ($errors->has('ContactMsg'))
                            <span class="text-danger">
                                {{ $errors->first('ContactMsg') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 margin-T-20 margin-B-100">
                    <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                    <button type="button" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div><!--container-->
</section>
@endsection
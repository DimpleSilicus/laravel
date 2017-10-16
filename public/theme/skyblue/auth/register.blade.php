@extends($theme.'.layouts.app')
@section('content')
  <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Sign Up</h2>
        </div>
    </section>
 <section>

        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <form id="registrationForm" role="form" method="POST" action="{{ url('user/register') }}" >
                     {!! csrf_field() !!}
                        <div class="col-sm-12 background-gray-lighter padding-30">
                            <h3 class="form-heading">Free Member</h3>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email"  value={{old('email')}}>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="email">Email ID *</label>
                                @if ($errors->has('email'))
                                <span class="text-danger">
                                    {{ $errors->first('email') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="userName" name="userName" value={{old('userName')}} >
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="Username">Username *</label>
                                 @if ($errors->has('userName'))
                                <span class="text-danger">
                                    {{ $errors->first('userName') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" value={{old('password')}}>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="Password">Password *</label>
                                @if ($errors->has('password'))
                                <span class="text-danger">
                                    {{ $errors->first('password') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value={{old('password_confirmation')}}>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="password_confirmation">Confirm Password *</label>
                                @if ($errors->has('password_confirmation'))
                                <span class="text-danger">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-sm-12 margin-T-20">
                                    <input type="hidden" name="gedcom" id="gedcom" value="0">
                                    <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                                    <button type="reset" class="btn btn-raised btn-default pull-right margin-R-20">Cancel</button>
                                </div>
                            </div>
                        </div>
                     <input type="hidden" name="userType" id="userType" value="freeMember">
                    </form>
                </div>

                <div class="col-sm-12 visible-sm margin-T-50"></div>
                <div class="col-xs-12 visible-xs margin-T-50"></div>

                <div class="col-md-6 col-sm-12 col-xs-12">
                    <form id="registrationFormPaid" role="form" method="POST" action="{{ url('user/Paidregister') }}" >
                        {!! csrf_field() !!}

                        <div class="col-sm-12 background-gray-lighter padding-30">
                            <h3 class="form-heading">Paid Member</h3>
                            <div class="form-group">
                                <input type="text" class="form-control" id="pemail" name="pemail" value={{old('email')}} >
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="PaidMemEmail">Email ID *</label>
                                @if ($errors->has('pemail'))
                                <span class="text-danger">
                                    {{ $errors->first('pemail') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="puserName" name="puserName" value={{old('puserName')}} >
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="PaidMemUsername">Username *</label>
                                @if ($errors->has('puserName'))
                                <span class="text-danger">
                                    {{ $errors->first('puserName') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="ppassword" name="ppassword" value={{old('ppassword')}}>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="PaidMemPassword">Password *</label>
                                @if ($errors->has('ppassword'))
                                <span class="text-danger">
                                    {{ $errors->first('ppassword') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="ppassword_confirmation" name="ppassword_confirmation" value={{old('ppassword_confirmation')}}>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="PaidMemConfirmPassword">Confirm password *</label>
                                @if ($errors->has('ppassword_confirmation'))
                                <span class="text-danger">
                                    {{ $errors->first('ppassword_confirmation') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <select class="form-control has-info" id="gedcom" name="gedcom" onchange="GetGedAmount(this.value)" placeholder="Placeholder">
                                    <option selected="selected" value="">Select Gedcom</option>
                                    
                                    @foreach ($arrPackages as $packages)                                                                   
                                        <option  value="{{$packages['id']}}">{{$packages['name']}}</option>
                                    @endforeach                                    
                                </select>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label for="Gedcom" class="hasdrodown">Select Gedcom *</label>
                                @if ($errors->has('gedcom'))
                                <span class="text-danger">
                                    {{ $errors->first('gedcom') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="hasdrodown"><strong id="GedComAmount" value=""></strong></label>
                                <input type="hidden" name="GedComAmt" id="GedComAmt" value="1">
                            </div>
                            <div class="row">
                                <div class="col-sm-12 margin-T-20">
                                    <button type="submit" class="btn btn-raised btn-green pull-right">MAKE PAYMENT</button>
                                    <button type="reset" class="btn btn-raised btn-default pull-right margin-R-20">Cancel</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="userType" id="userType" value="paidMember">
                    </form>
                </div>
            </div><!--row end-->
        </div><!--container end-->
    </section>
@endsection

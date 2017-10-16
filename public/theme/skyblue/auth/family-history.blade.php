@extends($theme.'.layouts.app')
@section('content')
 <div class="clearfix"></div>
    <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Family History</h2>
        </div>
    </section>
    <section class="margin-T-40 min-height-450">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="post">
                        <div class="image"><a href="text.html"><img src="{{ url('/theme') }}/{{$theme}}/img/home/family-history.jpg" alt="" class="img-responsive"></a></div>
                    </div>
                </div> <!--col-sm-4 end-->
                <div class="col-sm-8">
                    <div class="post">
                        <p class="post__intro">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                            <br /><br />
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                        </p>
                    </div>
                </div> <!--col-sm-8 end-->                
            </div><!--row end-->
        </div><!--container-->
    </section>
@endsection
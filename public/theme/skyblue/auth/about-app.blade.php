@extends($theme.'.layouts.app')
@section('content')
  <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">About GNH Application</h2>
        </div>
    </section>
    <section class="margin-T-20 min-height-450">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 margin-B-20">
                    <div class="image"><a href="text.html"><img src="{{ url('/theme') }}/{{$theme}}/img/home/about-gnh.jpg" alt="" class="img-responsive"></a></div>
                </div> <!--col-sm-4 end-->
                <div class="col-sm-12">
                    <div class="post">
                        <p class="post__intro">
                            Welcome to this site! Whether you are new to family history, or experienced, we offer services that are designed to assist the user researching their genealogy. Please use this application to connect to family, build your pedigree, and as a tool for personal family research and keeping.
                        </p>
                    </div>
                </div> <!--col-sm-12 end-->
            </div><!--row end-->
        </div><!--container-->
    </section>
    <!--   *** INTEGRATIONS ***-->
@endsection
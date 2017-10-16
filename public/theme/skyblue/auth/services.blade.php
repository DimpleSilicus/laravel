@extends($theme.'.layouts.app')
@section('content')
  <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">GNH Services</h2>
        </div>
    </section>
    <section class="margin-T-40 min-height-450">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="post">
                        <p class="post__intro">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                            <br /><br />
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                        </p>
                    </div>
                    <div class="panel-group nested-accordion" id="services-accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading actives-accordion" role="tab" id="MyNetwork-Search">
                                <h4 class="panel-title actives-accordion">
                                    <a role="button" data-toggle="collapse" data-parent="#services-accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Family History Auditing
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="MyNetwork-Search">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--search accordion end-->
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="MyNetwork-Request">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#services-accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Research Assistance
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="MyNetwork-Request">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--request received accordion end-->
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="MyNetwork-Group">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#services-accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Services 3
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="MyNetwork-Group">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--group accordion end-->
                    </div>
                </div> <!--col-sm-8 end-->
                <div class="col-sm-4">
                    <div class="post">
                        <div class="image"><a href="text.html"><img src="{{ url('/theme') }}/{{$theme}}/img/home/gnh-services.jpg" alt="Services" class="img-responsive"></a></div>
                    </div>
                </div> <!--col-sm-4 end-->
            </div><!--row end-->
        </div><!--container-->
    </section>
@endsection
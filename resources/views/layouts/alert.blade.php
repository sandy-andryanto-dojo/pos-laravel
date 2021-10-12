@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p class="text-left"><i class="fa fa-check"></i>&nbsp; Success , {!! $message !!}</p>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p class="text-left"><i class="fa fa-warning"></i>&nbsp; Warning , {!! $message !!}</p>
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p class="text-left"><i class="fa fa-info-circle"></i>&nbsp; Info , {!! $message !!}</p>
</div>
@endif

@if ($message = Session::get('danger'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p class="text-left"><i class="fa fa-ban"></i>&nbsp; Error , {!! $message !!}</p>
</div>
@endif
@extends('layouts.default')

@section('beforeContainer')
<div class="profile-cover-img" style="background: url('test.jpeg')">

  <!-- Camera Icon for User to change profile pictire -->
  <i href="{{url('profile/cover-image')}}" class="material-icons cover-photo-edit" data-toggle="tooltip" data-placement="right" title="Change cover image">camera_alt</i>

<div class="profile-wrapper">
  <img class="cover-profile-picture rounded-circle" src="profile.jpeg"
    data-toggle="tooltip" data-placement="top" title="Change profile picture" href="{{url('profile/profile-image')}}"
  >
  <h1>paul33</h1>
</div>
  <div class="cover-menu-bar"></div>
    <div class="cover-menu-wrapper">
      <span id="secondary-menu-posts" class="active">Posts</span>
      <span id="secondary-menu-dashboard">Dashboard</span>
      <span id="secondary-menu-settings">Settings</span>
    </div>
</div>
<!-- profile-cover-img -->
@endsection

@section('content')

@if(count($Stream) > 0) <!-- If there are posts to show -->

<div id="stream-wrapper">

@include('templates.stream-items')

</div> <!-- stream-wrapper -->
@endif <!-- if(count($Stream) > 0) -->


@endsection


@section('create')

@include('templates.create')

@endsection

@section('modals')

  @include('templates.modal.cbt')

@endsection

@extends('layout.subjectlayout')

@section('title', 'BACOMM')

<div class="container">
  <h1>@section('subject-title', 'BACHELOR IN ARTS SUBJECTS')</h1>
    
  
    <!-- Subject #1 -->
    @section('subject1', 'Introduction to Communication Studies')
    @section('subject1-url', url('/quantitative'))

     <!-- Subject #2 -->
    @section('subject2', 'Communication Research')

    <!-- Subject #3 -->
    @section('subject3', 'Interpersonal Communication')

    <!-- Subject #4 -->
    @section('subject4', 'Intercultural Communication')

    <!-- Subject #5 -->
    @section('subject5', 'Broadcast Communication')
    @section('subject6', 'Development Communication')
    @section('subject7', 'Communication Ethics')
    @section('subject8', 'Public Relations and Advertising')
    @section('subject9', 'Media and Information Literacy')
    @section('subject10', 'Digital Media Production')
    @section('subject11', 'Digital Media Production')
    @section('subject12', 'Digital Media Production')

  <!-- Images -->
    @section('subject-image1', asset('assets/img/BACOMM/.jpg'))
    @section('subject-image2', asset('assets/img/BACOMM/.jpg'))
    @section('subject-image3', asset('assets/img/BACOMM/.jpg'))
    @section('subject-image4', asset('assets/img/BACOMM/.jpg'))
    @section('subject-image5', asset('assets/img/BACOMM/.jpg'))
    @section('subject-image6', asset('assets/img/BACOMM/.jpg'))
    @section('subject-image7', asset('assets/img/BACOMM/.jpg'))
</div>


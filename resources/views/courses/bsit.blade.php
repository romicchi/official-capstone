@extends('layout.subjectlayout')

@section('title', 'BSIT')

<div class="container">
  <h1>@section('subject-title', 'BACHELOR IN INFORMATION TECHNOLOGY SUBJECTS')</h1>
  
    <!-- Subject #1 -->
    @section('subject1', 'Quantitative Methods and Simulation')
    @section('subject1-url', url('/quantitative'))

     <!-- Subject #2 -->
    @section('subject2', 'Arduino II')

    <!-- Subject #3 -->
    @section('subject3', 'Information Assurance and Security')

    <!-- Subject #4 -->
    @section('subject4', 'Web Development')

    <!-- Subject #5 -->
    @section('subject5', 'Computer Networks')
    @section('subject6', 'Computer Organization and Architecture')
    @section('subject7', 'Database Management Systems')
    @section('subject8', 'Operating Systems')
    @section('subject9', 'Software Engineering')
    @section('subject10', 'Computer Graphics')
    @section('subject11', 'Artificial Intelligence')
    @section('subject12', 'Computer Forensics')

  <!-- Images -->
    @section('subject-image1', asset('assets/img/BSIT/Quantitative.jpg'))
    @section('subject-image2', asset('assets/img/BSIT/Arduino.jpg'))
    @section('subject-image3', asset('assets/img/BSIT/IAS.jpg'))
    @section('subject-image4', asset('assets/img/BSIT/WebDevelopment.jpg'))
    @section('subject-image5', asset('assets/img/BSIT/ComputerNetworks.jpg'))
    @section('subject-image6', asset('assets/img/BSIT/ComputerOrganization.jpg'))
    @section('subject-image7', asset('assets/img/BSIT/DatabaseManagement.jpg'))
</div>


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
    @section('subject5', 'Computing Programming I - Java')
    @section('subject6', 'Discrete Mathematics')
    @section('subject7', 'Programming II - Python')
    @section('subject8', 'Computer Hardware Repair and Maintenance')
    @section('subject9', 'IT Elective I - Platform Technologies')
    @section('subject10', 'Fundamentals of Database System')
    @section('subject11', 'Cisco I - Networking Fundamentals')
    @section('subject12', 'Data Structure and Algorithms')

  <!-- Images -->
    @section('subject-image1', asset('assets/img/BSIT/Quantitative.jpg'))
    @section('subject-image2', asset('assets/img/BSIT/Arduino.jpg'))
    @section('subject-image3', asset('assets/img/BSIT/IAS.jpg'))
    @section('subject-image4', asset('assets/img/BSIT/WebDevelopment.jpg'))
    @section('subject-image5', asset('assets/img/BSIT/ComputerNetworks.jpg'))
    @section('subject-image6', asset('assets/img/BSIT/ComputerOrganization.jpg'))
    @section('subject-image7', asset('assets/img/BSIT/DatabaseManagement.jpg'))
</div>


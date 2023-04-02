@extends('admin')


<link rel="stylesheet" type="text/css" href="{{ asset ('css/admin.css')}}">

<!-- Search Bar -->
<div class="dropdown">
  <input class="form-control-sm" id="myInput" type="text" placeholder="Search..">
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>ReID</th>
          <th>Resources</th>
          <th>Approve</th>
          <th>Disapprove</th>
        </tr>
      </thead>
      {{--<tbody>
      @forelse ($items as $item)
          <tr>
            <td>{{ $item.ReID }}</td>
            <td>{{ $item.resources }}</td>
            <td><a href="{{ route('update', $item->id) }}">Approve</a></td>
            <td><a href="{{ route('delete', $item->id) }}">Disapprove</a></td>
          </tr>
          @empty 
          <tr>
            <td colspan="6">No items found.</td>
          </tr>
          @endforelse 
      </tbody> --}}
    </table>
  </div>
<!-- your courses content here -->

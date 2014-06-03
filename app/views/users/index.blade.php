@extends('layouts.admin_layout')

@section('content')
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>
          Name
        </th>
        <th>
          Email
        </th>
        <th>
          Phone Number
        </th>
        <th class="text-center">
          Total Leaves
        </th>
        <th class="text-center">
          Remaining Leaves
        </th>
        <th class="text-center">
          Actions
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        <tr>
          <td>
            {{$user->name}}
          </td>
          <td>
            {{$user->email}}
          </td>
          <td>
            {{$user->phone}}
          </td>
          <td class="text-center">
            {{$user->totalLeaves}}
          </td>
          <td class="text-center">
            -
          </td>
          <td align="center">
            <span class="btn btn-primary btn-xs">View Leaves</span>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@stop